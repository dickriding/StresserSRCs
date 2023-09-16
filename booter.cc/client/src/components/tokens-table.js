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

export const TokensTable = (props) => {
  const { tokens } = props;
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
                Token
              </TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {tokens.map((token) => {
              return (
                <TableRow key={token.value}>
                  <TableCell>
                    <Box>
                      <Typography
                        color="inherit"
                        variant="inherit"
                      >
                        {format(new Date(token.usedAt), 'dd MMM yyyy')}
                      </Typography>
                      <Typography
                        color="textSecondary"
                        variant="inherit"
                      >
                        {format(new Date(token.usedAt), 'HH:mm')}
                      </Typography>
                    </Box>
                  </TableCell>
                  <TableCell>
                    {token.value}
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

TokensTable.propTypes = {
  tokens: PropTypes.array.isRequired
};
