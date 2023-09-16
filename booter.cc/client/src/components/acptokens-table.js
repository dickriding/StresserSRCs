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
                Value
              </TableCell>
              <TableCell>
                Date
              </TableCell>
              <TableCell>
                Created by
              </TableCell>
              <TableCell>
                Note
              </TableCell>
              <TableCell>
                State
              </TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {tokens.map((token) => {
              return (
                <TableRow key={token.value}>
                  <TableCell>
                    <Link
                      color="inherit"
                      component={RouterLink}
                      to={`/super-secret-acp/token/${token.value}`}
                      underline="none"
                      variant="subtitle2"
                    >
                      {token.value}
                    </Link>
                  </TableCell>
                  <TableCell>
                    <Box>
                      <Typography
                        color="inherit"
                        variant="inherit"
                      >
                        {format(new Date(token.createdAt), 'dd MMM yyyy')}
                      </Typography>
                      <Typography
                        color="textSecondary"
                        variant="inherit"
                      >
                        {format(new Date(token.createdAt), 'HH:mm')}
                      </Typography>
                    </Box>
                  </TableCell>
                  <TableCell>
                    {token.createdBy}
                  </TableCell>
                  <TableCell>
                    {token.adminNote}
                  </TableCell>
                  <TableCell>
                    <Chip
                      label={token.used ? 'Claimed' : 'Available'}
                      color={token.used ? 'warning' : 'default'}
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

TokensTable.propTypes = {
  tokens: PropTypes.array.isRequired
};
