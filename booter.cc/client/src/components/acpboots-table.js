import PropTypes from 'prop-types';
import { Link as RouterLink } from 'react-router-dom';
import { format } from 'date-fns';
import {
  Box,
  Table,
  TableBody,
  Link,
  TableCell,
  TableHead,
  TableRow,
  Typography
} from '@material-ui/core';
import { Scrollbar } from './scrollbar';

export const BootsTable = (props) => {
  let { boots } = props;
  boots.sort(function (a, b) {
      return b.time.localeCompare(a.time);
  });
  return (
    <div>
      <Scrollbar>
        <Table sx={{ minWidth: 1000 }}>
          <TableHead>
            <TableRow>
              <TableCell>
                Date
              </TableCell>
              <TableCell>
                Destination
              </TableCell>
              <TableCell>
                User
              </TableCell>
              <TableCell>
                Method
              </TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {boots.map((boot) => {
              return (
                <TableRow key={boot.id}>
                  <TableCell>
                    <Box>
                      <Typography
                        color="inherit"
                        variant="inherit"
                      >
                        {format(new Date(boot.time), 'dd MMM yyyy')}
                      </Typography>
                      <Typography
                        color="textSecondary"
                        variant="inherit"
                      >
                        {format(new Date(boot.time), 'HH:mm')}
                      </Typography>
                    </Box>
                  </TableCell>
                  <TableCell>
                    {
                      boot.port ?
                      `${boot.destination}:${boot.port}` :
                      boot.destination
                    }
                  </TableCell>
                  <TableCell>
                    <Link
                      color="inherit"
                      component={RouterLink}
                      to={`/super-secret-acp/user/${boot.user}`}
                      underline="none"
                      variant="subtitle2"
                    >
                      {boot.user}
                    </Link>
                  </TableCell>
                  <TableCell>
                    {boot.method}
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

BootsTable.propTypes = {
  boots: PropTypes.array.isRequired,
};
