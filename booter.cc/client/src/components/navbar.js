import { useState } from 'react';
import { Link as RouterLink } from 'react-router-dom';
import { useTranslation } from 'react-i18next';
import useMediaQuery from '@material-ui/core/useMediaQuery';
import { AppBar, Box, Button, Divider, IconButton, Toolbar, Typography } from '@material-ui/core';
import { ChevronDown as ChevronDownIcon } from '../icons/chevron-down';
import { useSettings } from '../contexts/settings-context';
import { Moon as MoonIcon } from '../icons/moon';
import { Sun as SunIcon } from '../icons/sun';
import { Logo } from './logo';
import { AccountPopover } from './account-popover';
import { DashboardNavbarMenu } from './dashboard-navbar-menu';
import { NotificationsPopover } from './notifications-popover';

export const Navbar = () => {
  const mdDown = useMediaQuery((theme) => theme.breakpoints.down('md'));
  const { i18n, t } = useTranslation();
  const { settings, saveSettings } = useSettings();
  const [openMenu, setOpenMenu] = useState(false);
  const [darkMode, setDarkMode] = useState(settings.theme === 'dark');
  const [rtlDirection, setRtlDirection] = useState(settings.direction === 'rtl');

  const handleLanguageChange = (language) => {
    i18n.changeLanguage(language);
    saveSettings({
      ...settings,
      language
    });
  };

  const handleSwitchTheme = () => {
    saveSettings({
      ...settings,
      theme: settings.theme === 'light' ? 'dark' : 'light'
    });

    setDarkMode(settings.theme === 'light');
  };

  const handleSwitchDirection = () => {
    saveSettings({
      ...settings,
      direction: settings.direction === 'ltr' ? 'rtl' : 'ltr'
    });

    setRtlDirection(settings.direction === 'rtl');
  };

  return (
    <AppBar
      elevation={0}
      sx={{ backgroundColor: '#1e212a' }}
    >
      <Toolbar
        disableGutters
        sx={{
          alignItems: 'center',
          display: 'flex',
          minHeight: 64,
          px: 3,
          py: 1
        }}
      >
        <Box
          component={RouterLink}
          to="/"
          sx={{
            alignItems: 'center',
            display: 'flex',
            justifyContent: 'center'
          }}
        >
          <Logo
            emblemOnly
            variant="light"
          />
        </Box>
        <Divider
          flexItem
          orientation="vertical"
          sx={{
            borderColor: 'rgba(255,255,255,0.1)',
            mx: 3
          }}
        />
        <Typography
          color="textSecondary"
          sx={{
            color: 'primary.contrastText',
            mr: 3,
            display: {
              md: 'flex',
              xs: 'none'
            }
          }}
          variant="subtitle1"
        >
          BOOTER.CC
        </Typography>
        <DashboardNavbarMenu
          onClose={() => setOpenMenu(false)}
          open={mdDown && openMenu}
        />
        <Button
          endIcon={(
            <ChevronDownIcon
              fontSize="small"
              sx={{
                ml: 2,
                transition: 'transform 250ms',
                transform: openMenu ? 'rotate(180deg)' : 'none'
              }}
            />
          )}
          onClick={() => setOpenMenu(true)}
          sx={{
            color: 'primary.contrastText',
            display: {
              md: 'none',
              xs: 'flex'
            }
          }}
          variant="text"
        >
          Menu
        </Button>
        <Box sx={{ flexGrow: 1 }} />
        <IconButton
          color="inherit"
          onClick={handleSwitchTheme}
          sx={{
            mx: 2,
            display: {
              md: 'inline-flex',
              xs: 'none'
            }
          }}
        >
          {darkMode
            ? <SunIcon />
            : <MoonIcon />}
        </IconButton>
        <NotificationsPopover sx={{ mr: 2 }} />
        <AccountPopover
          darkMode={darkMode}
          onSwitchTheme={handleSwitchTheme}
        />
      </Toolbar>
    </AppBar>
  );
};
