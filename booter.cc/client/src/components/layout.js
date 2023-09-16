import { Outlet } from 'react-router-dom';
import { useMediaQuery } from '@material-ui/core';
import { styled } from '@material-ui/core/styles';
import { Footer } from '../components/footer';
import { Navbar } from '../components/navbar';
import { Sidebar } from '../components/sidebar';
import { useSettings } from '../contexts/settings-context';

const DashboardLayoutRoot = styled('div')(({ theme }) => ({
  backgroundColor: theme.palette.background.paper,
  height: '100%',
  paddingTop: 64
}));

const DashboardLayoutContent = styled('div')(() => ({
  display: 'flex',
  flexDirection: 'column',
  height: '100%'
}));

export const Layout = () => {
  const mdDown = useMediaQuery((theme) => theme.breakpoints.down('md'));
  const { settings, saveSettings } = useSettings();

  const handlePinSidebar = () => {
    saveSettings({
      ...settings,
      pinSidebar: !settings.pinSidebar
    });
  };

  return (
    <DashboardLayoutRoot>
      <Navbar />
      {!mdDown && (
        <Sidebar
          onPin={handlePinSidebar}
          pinned={settings.pinSidebar}
        />
      )}
      <DashboardLayoutContent
        sx={{
          ml: {
            md: settings.pinSidebar ? '270px' : '73px'
          }
        }}
      >
        <Outlet />
        <Footer />
      </DashboardLayoutContent>
    </DashboardLayoutRoot>
  );
};
