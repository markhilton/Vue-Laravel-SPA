<?php

namespace App\Http\Controllers;

use App\Site;
use Illuminate\Http\Request;

class SiteController extends Controller
{
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$data = Site::fetch(request()->all());

		return response()->json($data, 200);
	}


	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(Request $request)
	{
		try {
			return Site::create( request()->all() );
		}

		catch (\Exception $e) {
			return [
				'status'   => 'ERROR',
				'response' => $e->getMessage(),
				'request'  => request()->all(),
			];
		}
	}


	/**
	 * Display the specified resource.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		$site = Site::findOrFail($id);

		return $site;
	}


	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$response = [
			'status'   => 'OK',
			'response' => null,
			'request'  => request()->all(),
		];

		try {
			if ($site = Site::findOrFail($id)) {
				$site->fill(request()->all());
				$site->save();
			}

			$response['response'] = $site;
		}

		catch (\Exception $e) {
			$response['status']   = 'ERROR';
			$response['response'] = $e->getMessage();
		}

		return $response;
	}


	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int  $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		$response = [
			'status'   => 'OK',
			'response' => null,
			'request'  => [ 'id' => $id ],
		];

		try {
			if ($delete = Site::destroy($id)) {
				$response['response'] = 'Deleting requested site';
			} else {
				$response['status']   = 'ERROR';
				$response['response'] = 'Site delete failed';
			}
		}

		catch (\Exception $e) {
			$response['status']   = 'ERROR';
			$response['response'] = $e->getMessage();
		}

		return $response;
	}
}
