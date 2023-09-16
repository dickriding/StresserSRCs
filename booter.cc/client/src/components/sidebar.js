import { useEffect, useState } from 'react';
import { useLocation, matchPath } from 'react-router-dom';
import PropTypes from 'prop-types';
import { 
  Box, 
  Divider, 
  Drawer, 
  IconButton, 
  List 
} from '@material-ui/core';
import { DashboardSidebarItem } from './dashboard-sidebar-item';
import { Scrollbar } from './scrollbar';
import { ChevronLeft as ChevronLeftIcon } from '../icons/chevron-left';
import { ChevronRight as ChevronRightIcon } from '../icons/chevron-right';
import { Discord as DiscordIcon } from '../icons/discord';
import { Dashboard as DashboardIcon } from '../icons/dashboard';
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

export const Sidebar = (props) => {
  const { onPin, pinned } = props;
  const { pathname } = useLocation();
  const [openedItem, setOpenedItem] = useState(null);
  const [activeItem, setActiveItem] = useState(null);
  const [activeHref, setActiveHref] = useState('');
  const [hovered, setHovered] = useState(false);

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
      open
      sx={{ zIndex: 1000 }}
      variant="permanent"
      PaperProps={{
        onMouseOver: () => { setHovered(true); },
        onMouseLeave: () => { setHovered(false); },
        sx: {
          backgroundColor: 'background.paper',
          height: 'calc(100% - 64px)',
          overflowX: 'hidden',
          top: 64,
          transition: 'width 250ms ease-in-out',
          width: pinned ? 270 : 73,
          '& .simplebar-content': {
            height: '100%'
          },
          '&:hover': {
            width: 270,
            '& span, p': {
              display: 'flex'
            }
          }
        }
      }}
    >
      <Scrollbar
        style={{
          display: 'flex',
          flex: 1,
          overflowX: 'hidden',
          overflowY: 'auto'
        }}
      >
        <Box
          sx={{
            display: 'flex',
            flexDirection: 'column',
            height: '100%',
            p: 2
          }}
        >
          <List disablePadding>
            {activeItem && (items.map((item) => (
              <>
                {
                  item.admin ? (
                    <>
                      { isAdmin && (
                        <DashboardSidebarItem
                          active={activeItem?.title === item.title}
                          activeHref={activeHref}
                          key={item.title}
                          onOpen={() => handleOpenItem(item)}
                          open={openedItem?.title === item.title && (hovered || pinned)}
                          pinned={pinned}
                          {...item}
                        />
                      )}
                    </>
                  ) : (
                    <DashboardSidebarItem
                      active={activeItem?.title === item.title}
                      activeHref={activeHref}
                      key={item.title}
                      onOpen={() => handleOpenItem(item)}
                      open={openedItem?.title === item.title && (hovered || pinned)}
                      pinned={pinned}
                      {...item}
                    />
                  )
                }
              </>
            )))}
          </List>
          <Box sx={{ flexGrow: 1 }} />
          <Divider />
          <Box sx={{ pt: 1 }}>
            <IconButton onClick={onPin}>
              {pinned ? <ChevronLeftIcon /> : <ChevronRightIcon />}
            </IconButton>
          </Box>
        </Box>
      </Scrollbar>
    </Drawer>
  );
};

Sidebar.propTypes = {
  onPin: PropTypes.func,
  pinned: PropTypes.bool
};
