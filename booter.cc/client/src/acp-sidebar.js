import { Link as RouterLink, matchPath, useLocation } from 'react-router-dom';
import { Drawer, List, ListItem, ListItemIcon, ListItemText } from '@material-ui/core';
import { DocumentText as DocumentTextIcon } from '../icons/document-text';
import { Dashboard as DashboardIcon } from '../icons/dashboard';
import { Cog as CogIcon } from '../icons/cog';
import { ShoppingCart as ShoppingCartIcon } from '../icons/shopping-cart';
import { Tool as ToolIcon } from '../icons/tool';
import { Logout as LogoutIcon } from '../icons/logout';

const items = [
  {
    href: '/dashboard',
    icon: DashboardIcon,
    label: 'Dashboard'
  },
  {
    href: '/dashboard/tools',
    icon: ToolIcon,
    label: 'Tools'
  },
  {
    href: '/dashboard/orders',
    icon: ShoppingCartIcon,
    label: 'Orders'
  },
  {
    href: '/dashboard/documentation',
    icon: DocumentTextIcon,
    label: 'Docs'
  },
  {
    href: '/dashboard/settings',
    icon: CogIcon,
    label: 'Settings'
  },
  {
    href: '/logout',
    icon: LogoutIcon,
    label: 'Logout'
  },
];

export const SidebarACP = () => {
  const location = useLocation();
  
  return (
    <Drawer
      open
      sx={{ zIndex: 1000 }}
      variant="permanent"
      PaperProps={{
        sx: {
          backgroundColor: 'background.paper',
          display: 'flex',
          flexDirection: 'column',
          height: 'calc(100% - 64px)',
          p: 1,
          top: 64,
          width: 73
        }
      }}
    >
      <List sx={{ width: '100%' }}>
        {items.map(({ href, icon: Icon, label }) => {
          const active = matchPath({ path: href, end: true }, location.pathname);

          return (
            <ListItem
              disablePadding
              component={RouterLink}
              key={href}
              to={href}
              sx={{
                flexDirection: 'column',
                color: active ? 'primary.main' : 'text.secondary',
                px: 2,
                py: 1.5,
                '&:hover': {
                  color: 'primary.main'
                }
              }}
            >
              <ListItemIcon
                sx={{
                  minWidth: 'auto',
                  color: 'inherit'
                }}
              >
                <Icon />
              </ListItemIcon>
              <ListItemText
                primary={label}
                primaryTypographyProps={{
                  sx: {
                    pb: 0,
                    pt: 1.25
                  },
                  variant: 'caption'
                }}
              />
            </ListItem>
          );
        })}
      </List>
    </Drawer>
  );
};
