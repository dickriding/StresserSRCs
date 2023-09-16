import { useState, useEffect } from 'react';
import { matchPath, useLocation } from 'react-router-dom';
import PropTypes from 'prop-types';
import { Drawer, List } from '@material-ui/core';
import { DashboardNavbarMenuItem } from './dashboard-navbar-menu-item';
import { DocumentText as DocumentTextIcon } from '../icons/document-text';
import { Dashboard as DashboardIcon } from '../icons/dashboard';
import { Discord as DiscordIcon } from '../icons/discord';
import { Cog as CogIcon } from '../icons/cog';
import { ShoppingCart as ShoppingCartIcon } from '../icons/shopping-cart';
import { Logout as LogoutIcon } from '../icons/logout';
import { Telegram as TelegramIcon } from '../icons/telegram';
import { Eye as EyeIcon } from '../icons/eye';
import authenticate2 from '../handler/authenticate2';

const items = [
  {
    icon: DashboardIcon,
    title: 'Dashboard',
    items: [
      {
        href: '/dashboard/',
        title: 'Attack Hub'
      },
      {
        href: '/dashboard/tools',
        title: 'Tools'
      }
    ]
  },
  {
    icon: ShoppingCartIcon,
    title: 'Subscription',
    items: [
      {
        href: '/dashboard/orders',
        title: 'Order'
      },
      {
        href: '/dashboard/tokens',
        title: 'Token'
      }
    ]
  },
  {
    icon: CogIcon,
    title: 'Account',
    items: [
      {
        href: '/dashboard/settings',
        title: 'General Settings'
      },
      {
        href: '/dashboard/documentation',
        title: 'API keys'
      },
    ]
  },
  {
    icon: EyeIcon,
    title: 'Administration',
    admin: true,
    items: [
      {
        href: '/super-secret-acp',
        title: 'Tower'
      },
      {
        href: '/super-secret-acp/notifications',
        title: 'Notifications'
      },
      {
        href: '/super-secret-acp/users',
        title: 'Users'
      },
      {
        href: '/super-secret-acp/orders',
        title: 'Orders'
      },
      {
        href: '/super-secret-acp/methods',
        title: 'Methods'
      },
      {
        href: '/super-secret-acp/debug',
        title: 'Debugger'
      }
    ]
  },
  // {
  //   icon: DiscordIcon,
  //   title: 'Discord',
  //   href: '/discord',
  //   external: true
  // },
  {
    icon: TelegramIcon,
    title: 'Telegram',
    href: '/telegram',
    external: true
  }
];

export const DashboardNavbarMenu = (props) => {
  const { open, onClose } = props;
  const { pathname } = useLocation();
  const [openedItem, setOpenedItem] = useState(null);
  const [activeItem, setActiveItem] = useState(null);
  const [activeHref, setActiveHref] = useState('');

  const handleOpenItem = (item) => {
    if (openedItem === item) {
      setOpenedItem(null);
      return;
    }

    setOpenedItem(item);
  };

  useEffect(() => {
    items.forEach((item) => {
      if (item.items) {
        for (let index = 0; index < item.items.length; index++) {
          const active = matchPath({ path: item.items[index].href, end: true }, pathname);

          if (active) {
            setActiveItem(item);
            setActiveHref(item.items[index].href);
            setOpenedItem(item);
            break;
          }
        }
      } else {
        const active = !!matchPath({ path: item.href, end: true }, pathname);

        if (active) {
          setActiveItem(item);
          setOpenedItem(item);
        }
      }
    });
  }, [pathname]);

  const [isAdmin, setAdmin] = useState(false)
  useEffect( () => {
    const fetchData = async () => {
      const res = await authenticate2()
      setAdmin(res)
    }
    fetchData()
  }, [])
  
  return (
    <Drawer
      anchor="top"
      onClose={onClose}
      open={open}
      transitionDuration={0}
      ModalProps={{
        BackdropProps: {
          invisible: true
        }
      }}
      PaperProps={{
        sx: {
          backgroundColor: '#2B2F3C',
          color: '#B2B7C8',
          display: 'flex',
          flexDirection: 'column',
          top: 64,
          maxHeight: 'calc(100% - 64px)',
          width: '100vw'
        }
      }}
    >
      <List>
        {activeItem && (items.map((item) => (
          <>
            {
              item.admin ? (
                <>
                  { isAdmin && (
                    <DashboardNavbarMenuItem
                      active={activeItem?.title === item.title}
                      activeHref={activeHref}
                      key={item.title}
                      onClose={onClose}
                      onOpenItem={() => handleOpenItem(item)}
                      open={openedItem?.title === item.title}
                      {...item}
                    />
                  )}
                </>
              ) : (
                <DashboardNavbarMenuItem
                  active={activeItem?.title === item.title}
                  activeHref={activeHref}
                  key={item.title}
                  onClose={onClose}
                  onOpenItem={() => handleOpenItem(item)}
                  open={openedItem?.title === item.title}
                  {...item}
                />
              )
            }
          </>
        )))}
      </List>
    </Drawer>
  );
};

DashboardNavbarMenu.propTypes = {
  open: PropTypes.bool,
  onClose: PropTypes.func
};
