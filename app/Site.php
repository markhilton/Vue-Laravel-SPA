<?php

namespace App;

use Auth;
use Validator;
use App\Site;
use Jenssegers\Mongodb\Eloquent\Model as Eloquent;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;

class Site extends Eloquent
{
	use SoftDeletes;

	protected $connection = 'mongodb';
	protected $collection = 'sites';
	protected $hidden     = [ 'deleted_at', ];

	protected static $rules  = [
		'name' => 'required|unique:sites|max:255',
		'slug' => 'unique',
	];

	protected static $errors = [];

	/**
	 * The attributes that are mass assignable.
	 *
	 * @var array
	 */
	protected $fillable = [
		'name', 'status', 'type', 'engine',
		'settings', 'env', # environment variables array
	];

	protected static $statuses = [
		'active'    => [ 'name' => "Site is OK",                 'color' => 'success', 'icon' => 'thumb_up' ],            // site's active and operating
		'disabled'  => [ 'name' => "Site is disabled",           'color' => 'grey',    'icon' => 'power_settings_new' ],  // site's temporarly disabled by user
		'pending'   => [ 'name' => "Site is updating",           'color' => 'info',    'icon' => 'fas fa-circle-notch fa-spin' ],            // site's updating at the moment
		'suspended' => [ 'name' => "Site is suspended",          'color' => 'warning', 'icon' => 'highlight_off' ],       // site's suspended by system for some violation: payment, wrong config etc
		'error'     => [ 'name' => "Site experienced an error",  'color' => 'error',   'icon' => 'thumb_down' ],          // site error
	];

	public static $engine = [
		'5.6',
		'7.0',
		'7.1',
		'7.2',
	];

	public static function boot()
	{
		parent::boot();

		// create a event to happen on updating
		static::updating(function ($data) {
			$data->updated_by = Auth::user()->id ?? null;
		});

		// create a event to happen on deleting
		static::deleting(function ($data) {
			$data->updated_by = Auth::user()->id ?? null;
			$data->save();
		});

		// create a event to happen on saving
		static::creating(function ($data) {
			$data->created_by = Auth::user()->id ?? null;
			$data->engine     = $data->engine    ?? '7.2';
			$data->status     = $data->status    ?? 'pending';
			$data->team_owner = Auth::user()->currentTeam->id ?? null;
			$data->slug       = preg_replace("/[^a-z0-9-]/", "", str_slug($data->name));
		});
	}

	public function creator()
	{
		return $this->belongsTo('App\User', 'created_by', 'id');
	}

	public function updater()
	{
		return $this->belongsTo('App\User', 'updated_by', 'id');
	}

	public static function getRules()
	{
		return self::$rules;
	}

	public static function getStatuses()
	{
		return self::$statuses;
	}

	/**
	 * fetch
	 *
	 */
	public static function fetch($data)
	{
		$query = array();

		$query['search'] = $data['search'] ?? false;
		$query['sort']   = $data['sortBy'] ?? 'created_at';
		$query['page']   = (int) ($data['page'] ?? 1);
		$query['limit']  = (int) ($data['rowsPerPage'] ?? 10);
		$query['offset'] = $query['page'] * $query['limit'] - $query['limit'];
		$query['order']  = $data['descending'] == 'true' ? 'desc' : 'asc';

		$data = self::select()->limit($query['limit']);

		// if (! in_array(Auth::user()->email, Spark::$developers)) {
		// 	// $data = $data->where('created_by', '=', Auth::id());
		// 	$data = $data->where('team_owner', '=', Auth::user()->currentTeam->id);
		// }

		$total = $data->count();

		// search
		if ($query['search']) {
			$data = $data->where('name', 'like', '%' . $query['search'] . '%');
		}

		// apply sorting when requested
		if ($query['offset']) {
			$data = $data->offset($query['offset']);
		}

		// apply sorting when requested
		if ($query['sort']) {
			$data = $data->orderBy($query['sort'], $query['order']);
		}

		$feed = [
			'items' => $data->get(),
			'total' => $total,
			'query' => $query,
		];

		return $feed;
	}

	/**
	 * create
	 *
	 */
	public static function create($data)
	{
		// have to switch default db connection to MongoDB in order to use Validator
		\Config::set('database.default', 'mongodb');

		$validator = Validator::make($data, self::getRules());

		if ($validator->fails()) {
			return [
				'status'   => 'ERROR',
				'request'  => $data,
				'response' => $validator->errors(),
			];
		}

		$site = new Site();
		$site->fill($data);
		$site->save();

		return [
			'status'   => 'OK',
			'request'  => $data,
			'response' => $site,
		];
	}

	/**
	 * Validate input
	 *
	 */
	public function validate($data)
	{
		$validate     = Validator::make($data, $this->rules, is_array($this->messages) ? $this->messages : []);
		self::$errors = $validate->errors()->all();

		return $validate->passes();
	}

	/** **/
}
