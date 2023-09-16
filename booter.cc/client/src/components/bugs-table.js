import PropTypes from 'prop-types';
import { format } from 'date-fns';
import {
  Box,
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableRow,
  Typography
} from '@material-ui/core';
import { Scrollbar } from './scrollbar';

export const BugsTable = (props) => {
  const { bugs } = props;
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
                Message
              </TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {bugs.map((bug) => {
              return (
                <TableRow key={bug.id}>
                  <TableCell>
                    <Box>
                      <Typography
                        color="inherit"
                        variant="inherit"
                      >
                        {format(new Date(bug.time), 'dd MMM yyyy')}
                      </Typography>
                      <Typography
                        color="textSecondary"
                        variant="inherit"
                      >
                        {format(new Date(bug.time), 'HH:mm')}
                      </Typography>
                    </Box>
                  </TableCell>
                  <TableCell>
                    {bug.error}
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

BugsTable.propTypes = {
  bugs: PropTypes.array.isRequired
};
