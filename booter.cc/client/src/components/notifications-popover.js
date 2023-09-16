import { format } from 'date-fns';
import {
  Badge,
  Box,
  IconButton,
  Typography,
  Popover,
  List,
  ListItem,
  ListSubheader
} from '@material-ui/core';
import { usePopover } from '../hooks/use-popover';
import { Bell as BellIcon } from '../icons/bell';
import { Sparkles as SparklesIcon } from '../icons/sparkles';
import { Speakerphone as SpeakerphoneIcon } from '../icons/speakerphone';

const notifications = [
  {
    id: '1',
    content: 'BOOTER.CC Layer 4 is currently not working and will be up soon. .',
    createdAt: new Date().getTime(),
    icon: SparklesIcon,
    iconColor: '#ffb400',
    title: 'Layer 4 Maintenance'
  },
  {
    id: '2',
    content: 'We have updated the website\'s frontend to something more dynamic, responsive and intuitive.',
    createdAt: new Date().getTime(),
    icon: SpeakerphoneIcon,
    iconColor: '#4970ff',
    title: 'UI/UX update'
  }
];

export const NotificationsPopover = (props) => {
  const [anchorRef, open, handleOpen, handleClose] = usePopover();

  return (
    <>
      {/*<Badge*/}
      {/*  color="success"*/}
      {/*  variant="dot"*/}
      {/*  {...props}*/}
      {/*>*/}
      {/*  <IconButton*/}
      {/*    onClick={handleOpen}*/}
      {/*    ref={anchorRef}*/}
      {/*    sx={{*/}
      {/*      color: 'primary.contrastText'*/}
      {/*    }}*/}
      {/*  >*/}
      {/*    <BellIcon />*/}
      {/*  </IconButton>*/}
      {/*</Badge>*/}
      {/*<Popover*/}
      {/*  anchorEl={anchorRef.current}*/}
      {/*  anchorOrigin={{*/}
      {/*    horizontal: 'center',*/}
      {/*    vertical: 'bottom'*/}
      {/*  }}*/}
      {/*  keepMounted*/}
      {/*  onClose={handleClose}*/}
      {/*  open={open}*/}
      {/*  PaperProps={{*/}
      {/*    sx: { width: 320 }*/}
      {/*  }}*/}
      {/*>*/}
      {/*  <List>*/}
      {/*    <ListSubheader sx={{ py: 1 }}>*/}
      {/*      Notifications*/}
      {/*    </ListSubheader>*/}
      {/*    {notifications.map((notification, index) => {*/}
      {/*      const { title, content, createdAt, icon: Icon, iconColor } = notification;*/}

      {/*      return (*/}
      {/*        <ListItem*/}
      {/*          disableGutters*/}
      {/*          divider={notifications.length > index + 1}*/}
      {/*          key={notification.id}*/}
      {/*          sx={{*/}
      {/*            display: 'flex',*/}
      {/*            alignItems: 'flex-start',*/}
      {/*            flexDirection: 'column',*/}
      {/*            p: 2*/}
      {/*          }}*/}
      {/*        >*/}
      {/*          <Box sx={{ display: 'flex' }}>*/}
      {/*            <Icon*/}
      {/*              fontSize="small"*/}
      {/*              sx={{ color: iconColor }}*/}
      {/*            />*/}
      {/*            <Typography*/}
      {/*              color="textPrimary"*/}
      {/*              sx={{ ml: 1.25 }}*/}
      {/*              variant="body1"*/}
      {/*            >*/}
      {/*              {title}*/}
      {/*            </Typography>*/}
      {/*          </Box>*/}
      {/*          <Typography*/}
      {/*            color="textSecondary"*/}
      {/*            variant="body2"*/}
      {/*          >*/}
      {/*            {content}*/}
      {/*          </Typography>*/}
      {/*          <Typography*/}
      {/*            color="textSecondary"*/}
      {/*            variant="caption"*/}
      {/*          >*/}
      {/*            {format(createdAt, 'MMM dd, yyyy')}*/}
      {/*          </Typography>*/}
      {/*        </ListItem>*/}
      {/*      );*/}
      {/*    })}*/}
      {/*  </List>*/}
      {/*</Popover>*/}
    </>
  );
};
