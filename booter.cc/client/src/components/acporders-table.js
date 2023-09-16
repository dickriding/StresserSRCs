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

const statusVariants = [
  {
    label: 'Awaiting',
    value: 0
  },
  {
    label: 'Unconfirmed',
    value: 1
  },
  {
    label: 'Paid',
    value: 2
  },
  {
    label: 'Underpaid',
    value: 3
  },
  {
    label: 'Overpaid',
    value: 4
  },
  {
    label: 'Expired',
    value: 5
  },
  {
    label: 'Canceled',
    value : 6
  }
];

export const OrdersTable = (props) => {
  const { orders } = props;
  return (
    <div>
      <Scrollbar>
        <Table sx={{ minWidth: 1000 }}>
          <TableHead>
            <TableRow>
              <TableCell>
                Order
              </TableCell>
              <TableCell>
                Date
              </TableCell>
              <TableCell>
                User
              </TableCell>
              <TableCell>
                Price (BTC)
              </TableCell>
              <TableCell>
                Status
              </TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {orders.map((order) => {
              const statusVariant = statusVariants.find(
                (variant) => variant.value === order.status
              );

              return (
                <TableRow key={order.txn_id}>
                  <TableCell>
                    <Link
                      color="inherit"
                      component={RouterLink}
                      to={`/super-secret-acp/order/${order.txn_id}`}
                      underline="none"
                      variant="subtitle2"
                    >
                      {`#${order.txn_id}`}
                    </Link>
                  </TableCell>
                  <TableCell>
                    <Box>
                      <Typography
                        color="inherit"
                        variant="inherit"
                      >
                        {format(new Date(order.start), 'dd MMM yyyy')}
                      </Typography>
                      <Typography
                        color="textSecondary"
                        variant="inherit"
                      >
                        {format(new Date(order.start), 'HH:mm')}
                      </Typography>
                    </Box>
                  </TableCell>
                  <TableCell>
                    {order.user}
                  </TableCell>
                  <TableCell>
                    {order.amount}
                  </TableCell>
                  <TableCell>
                    <Chip
                      label={order.status_text}
                      color={order.status === -1 ? 'error' : (order.status === 1 ? 'warning' : (order.status === 100 ? 'success' : 'primary'))}
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

OrdersTable.propTypes = {
  orders: PropTypes.array.isRequired
};
