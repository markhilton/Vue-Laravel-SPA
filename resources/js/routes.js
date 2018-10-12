// auth components
import Login from '../components/auth/Login';
import Register from '../components/auth/Register';
import PasswordEmail from '../components/auth/PasswordEmail'
import PasswordReset from '../components/auth/PasswordReset'

// dashboard
import Dashboard from '../components/dashboard/index';

// site components
import Sites from '../components/sites/index';
import SiteCreate from '../components/sites/create';
import SiteUpdate from '../components/sites/update';
import SiteDelete from '../components/sites/delete';

// customer components
import CustomersMain from '../components/customers/Main';
import CustomersList from '../components/customers/List';
import NewCustomer from '../components/customers/New';
import Customer from '../components/customers/View';

export const routes = [
    {
        path: '/',
        component: Dashboard,
        meta: {
            requiresAuth: true
        },
    },
    {
        path: '/register',
        component: Register
    },
    {
        path: '/login',
        component: Login
    },
    {
		path: '/password/email',
		name: 'auth.password.email',
		component: PasswordEmail
	},
	{
		path: '/password/reset',
		name: 'auth.password.reset',
		component: PasswordReset
	},
    {
        path: '/sites',
        component: Sites,
        meta: {
            requiresAuth: true
        }
    },
    {
        path: '/customers',
        component: CustomersMain,
        meta: {
            requiresAuth: true
        },
        children: [
            {
                path: '/',
                component: CustomersList
            },
            {
                path: 'new',
                component: NewCustomer
            },
            {
                path: ':id',
                component: Customer
            }
        ]
    }
];
