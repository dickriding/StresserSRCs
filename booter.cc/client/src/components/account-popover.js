import { useState, useEffect } from 'react'; 
import PropTypes from 'prop-types';
import { Link as RouterLink, useNavigate } from 'react-router-dom';
import {
  Avatar,
  Box,
  Typography,
  Popover,
  List,
  ListItem,
  ListItemAvatar,
  ListItemText,
  ListItemIcon,
  Switch,
  ListSubheader
} from '@material-ui/core';
import { usePopover } from '../hooks/use-popover';
import authenticate from '../handler/authenticate';
import Axios from '../handler/axios';
import { ChevronDown as ChevronDownIcon } from '../icons/chevron-down';
import { Logout as LogoutIcon } from '../icons/logout';
import { User as UserIcon } from '../icons/user';
import { lightNeutral } from '../colors';
import { getTime } from 'date-fns';

export const AccountPopover = (props) => {
  const {
    darkMode,
    onSwitchTheme,
    ...other
  } = props;
  const navigate = useNavigate();
  const [anchorRef, open, handleOpen, handleClose] = usePopover();

  const [info, setInfo] = useState({
    username : '',
    email : ''
  })

  useEffect( () => {
    async function fetchData() {
      const token = getTime(new Date())
      const request = await Axios.get(`/settings/getData/${token}`)
      if(request.data.success) {
        setInfo(request.data.message)
      }
    }
    fetchData();
  }, [])

  const handleLogout = async (event) => {
    event.preventDefault();
    const authRequest = await authenticate()
    if(!authRequest)
      window.location.href = '/login'
    const token = getTime(new Date())
    const request = await Axios.get(`/logout/${token}`)
    if(request.data.success) {
      localStorage.removeItem('authorizationToken')
      window.location.href = '/login';
    }
  }
  return (
    <>
      <Box
        onClick={handleOpen}
        ref={anchorRef}
        sx={{
          alignItems: 'center',
          cursor: 'pointer',
          display: 'flex',
          ml: 2
        }}
        {...other}
      >
        <Avatar
          src="/static/user-chen_simmons.png"
          variant="rounded"
          sx={{
            height: 40,
            width: 40
          }}
        />
        <Box
          sx={{
            alignItems: 'center',
            display: {
              md: 'flex',
              xs: 'none'
            },
            flex: 1,
            ml: 1,
            minWidth: 120
          }}
        >
          <div>
            <Typography
              sx={{
                color: lightNeutral[500]
              }}
              variant="caption"
            >
              User
            </Typography>
            <Typography
              sx={{ color: 'primary.contrastText' }}
              variant="subtitle2"
            >
              {info.username}
            </Typography>
          </div>
          <ChevronDownIcon
            sx={{
              color: 'primary.contrastText',
              ml: 1
            }}
          />
        </Box>
      </Box>
      <Popover
        anchorEl={anchorRef.current}
        anchorOrigin={{
          horizontal: 'center',
          vertical: 'bottom'
        }}
        keepMounted
        onClose={handleClose}
        open={open}
        PaperProps={{
          sx: {
            width: 260,
            display: 'flex',
            flexDirection: 'column'
          }
        }}
      >
        <List>
          <ListItem divider>
            <ListItemAvatar>
              <Avatar
                variant="rounded"
                src="/static/user-chen_simmons.png"
              />
            </ListItemAvatar>
            <ListItemText
              primary={info.username}
              secondary='天空'
            />
          </ListItem>
          <li>
            <List disablePadding>
              <ListSubheader disableSticky>
                App Settings
              </ListSubheader>
              <ListItem
                sx={{
                  py: 0,
                  display: {
                    md: 'none',
                    xs: 'flex'
                  }
                }}
              >
                <Switch
                  checked={darkMode}
                  onChange={onSwitchTheme}
                />
                <Typography
                  color="textPrimary"
                  variant="body2"
                >
                  Dark Mode
                </Typography>
              </ListItem>
            </List>
          </li>
          <ListItem
            button
            component={RouterLink}
            divider
            onClick={handleClose}
            to="/dashboard/settings"
          >
            <ListItemIcon>
              <UserIcon />
            </ListItemIcon>
            <ListItemText primary="Account" />
          </ListItem>
          <ListItem
            button
            onClick={handleLogout}
          >
            <ListItemIcon>
              <LogoutIcon />
            </ListItemIcon>
            <ListItemText primary="Log out" />
          </ListItem>
        </List>
      </Popover>
    </>
  );
};

AccountPopover.propTypes = {
  darkMode: PropTypes.bool.isRequired,
  onSwitchTheme: PropTypes.func.isRequired,
};
