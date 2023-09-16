import { useRoutes } from 'react-router-dom';
import { CssBaseline, ThemeProvider } from '@material-ui/core';
import { createCustomTheme } from './theme';
import { useSettings } from './contexts/settings-context';
import { routes } from './routes';

import 'react-toastify/dist/ReactToastify.css';

const App = () => {
  const content = useRoutes(routes);
  const { settings } = useSettings();

  const theme = createCustomTheme({
    direction: settings.direction,
    theme: settings.theme
  });

  return (
    <ThemeProvider theme={theme}>
      <CssBaseline />
      {content}
    </ThemeProvider>
  );
};

export default App;
