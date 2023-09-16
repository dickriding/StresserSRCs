import PropTypes from 'prop-types';
import { format } from 'date-fns';
import {
  Box,
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableRow,
  Chip,
  Typography
} from '@material-ui/core';
import { Scrollbar } from './scrollbar';

export const ServersTable = (props) => {
  const { socketsInfo } = props;
  return (
    <div>
      <Scrollbar>
        <Table sx={{ minWidth: 1000 }}>
          <TableHead>
            <TableRow>
              <TableCell>
                Country
              </TableCell>
              <TableCell>
                IPv4 Address
              </TableCell>
              <TableCell>
                Joined
              </TableCell>
              <TableCell>
                Botnet
              </TableCell>
              <TableCell>
                Organization
              </TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {socketsInfo.map((socket, i) => {
              return (
                <TableRow key={i}>
                  <TableCell>
                    <img alt={socket.ip} src={`https://www.countryflags.io/${socket.countrycode.toLowerCase()}/flat/32.png`} />
                  </TableCell>
                  <TableCell>
                    {socket.ip}
                  </TableCell>
                  <TableCell>
                    <Box>
                      <Typography
                        color="inherit"
                        variant="inherit"
                      >
                        {format(new Date(socket.connected), 'dd MMM yyyy')}
                      </Typography>
                      <Typography
                        color="textSecondary"
                        variant="inherit"
                      >
                        {format(new Date(socket.connected), 'HH:mm')}
                      </Typography>
                    </Box>
                  </TableCell>
                  <TableCell>
                    <Chip
                      label={socket.node}
                      color={socket.node === 'main' ? 'success' : 'warning'}
                      variant="outlined"
                    />
                  </TableCell>
                  <TableCell>
                    {socket.org}
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

ServersTable.propTypes = {
  socketsInfo: PropTypes.array.isRequired,
};
