import PropTypes from 'prop-types';
import { Link as RouterLink } from 'react-router-dom';
import { format } from 'date-fns';
import {
  Box,
  Chip,
  Link,
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableRow,
  Typography
} from '@material-ui/core';
import { Scrollbar } from './scrollbar';

export const UsersTable = (props) => {
  const { users } = props;
  return (
    <div>
      <Scrollbar>
        <Table sx={{ minWidth: 1000 }}>
          <TableHead>
            <TableRow>
              <TableCell>
                Username
              </TableCell>
              <TableCell>
                Email
              </TableCell>
              <TableCell>
                Date
              </TableCell>
              <TableCell>
                Status
              </TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {users.map((user) => {
              let statusVariant = 'Free'
              if(user.subbed)
                statusVariant = 'Paid'
              if(user.admin)
                statusVariant = 'Admin'
              if(user.banned)
                statusVariant = 'Banned'
              return (
                <TableRow key={user.username}>
                  <TableCell>
                    <Link
                      color="inherit"
                      component={RouterLink}
                      to={`/super-secret-acp/user/${user.username}`}
                      underline="none"
                      variant="subtitle2"
                    >
                      {user.username}
                    </Link>
                  </TableCell>
                  <TableCell>
                    {user.email}
                  </TableCell>
                  <TableCell>
                    <Box>
                      <Typography
                        color="inherit"
                        variant="inherit"
                      >
                        {format(new Date(user.date), 'dd MMM yyyy')}
                      </Typography>
                      <Typography
                        color="textSecondary"
                        variant="inherit"
                      >
                        {format(new Date(user.date), 'HH:mm')}
                      </Typography>
                    </Box>
                  </TableCell>
                  <TableCell>
                    <Chip
                      label={statusVariant}
                      color={user.admin ? 'primary' : (user.banned ? 'error' : (user.subbed ? 'secondary' : 'default'))}
                      variant="outlined"
                    />
                  </TableCell>
                </TableRow>
              );
            })}
          </TableBody>
        </Table>
      </Scrollbar>
    </div>
  );
};

UsersTable.propTypes = {
  users: PropTypes.array.isRequired
};
