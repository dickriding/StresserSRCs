import { Navigate } from 'react-router-dom';

import { Layout } from './components/layout';

import { NotFound } from './pages/not-found';
import { Orders } from './pages/orders';
import { Order } from './pages/order';
import { Dashboard } from './pages/dashboard';
import { Settings } from './pages/settings';
import { Documentation } from './pages/docs';
import { Login } from './pages/login';
import { Register } from './pages/register';
import { Tools } from './pages/tools';
import { Tokens } from './pages/tokens';

import { Telegram } from './pages/telegram';
import { Discord } from './pages/discord';

import { Debugs } from './admin/debug';
import { Users } from './admin/users';
import { User } from './admin/user';
import { OrdersACP } from './admin/orders';
import { OrderACP } from './admin/order';
import { TokenACP } from './admin/token';
import { Methods } from './admin/methods';
import { Tower } from './admin/tower';
import { AnnouncementACP } from './admin/announcements';

export const routes = [
  {
    path: '/',
    element: <Navigate to="/dashboard" />
  },
  {
    path: '/login',
    element: <Login />
  },
  {
    path: '/register',
    element: <Register />
  },
  {
    path: 'dashboard',
    element: <Layout />,
    children: [
      {
        path: '/',
        element: <Dashboard />
      },
      {
        path: 'orders',
        element: <Orders />
      },
      {
        path: 'order/:id',
        element: <Order />
      },
      {
        path: 'tokens',
        element: <Tokens />
      },
      {
        path: 'tools',
        element: <Tools />
      },
      {
        path: 'documentation',
        element: <Documentation />
      },
      {
        path: 'settings',
        element: <Settings />
      },
      {
        path: '*',
        element: <Navigate to="/404" />
      }
    ]
  },
  {
    path: 'super-secret-acp',
    element: <Layout />,
    children: [
      {
        path: '/',
        element: <Tower />
      },
      {
        path: 'users',
        element: <Users />
      },
      {
        path:'user/:id',
        element: <User />
      },
      {
        path: 'notifications',
        element: <AnnouncementACP />
      },
      {
        path: 'orders',
        element: <OrdersACP />
      },
      {
        path: 'order/:id',
        element: <OrderACP />
      },
      {
        path: 'token/:id',
        element: <TokenACP />
      },
      {
        path: 'methods',
        element: <Methods />
      },
      {
        path: 'debug',
        element: <Debugs />
      },
      {
        path: '*',
        element: <Navigate to="/404" />
      }
    ]
  },
  {
    path: 'telegram',
    element: <Telegram />
  },
  {
    path: 'discord',
    element: <Discord />
  },
  {
    path: '404',
    element: <NotFound />
  }
];
