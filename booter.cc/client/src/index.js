import 'simplebar/dist/simplebar.min.css';
import ReactDOM from 'react-dom';
import { BrowserRouter } from 'react-router-dom';
import { SettingsProvider } from './contexts/settings-context';
import App from './app';

ReactDOM.render((
  <BrowserRouter>
    <SettingsProvider>
      <App />
    </SettingsProvider>
  </BrowserRouter>
), document.getElementById('root'));
