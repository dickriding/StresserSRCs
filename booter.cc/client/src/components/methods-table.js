import PropTypes from 'prop-types';
import {
  Chip,
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableRow,
  IconButton
} from '@material-ui/core';
import { Scrollbar } from './scrollbar';
import Axios from '../handler/axios';

export const MethodsTable = (props) => {
  const { methods } = props;
  return (
    <div>
      <Scrollbar>
        <Table sx={{ minWidth: 1000 }}>
          <TableHead>
            <TableRow>
              <TableCell>
                Name
              </TableCell>
              <TableCell>
                Description
              </TableCell>
              <TableCell>
                API value
              </TableCell>
              <TableCell>
                Layer
              </TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {methods.map((method) => {
              return (
                <TableRow key={method.title}>
                  <TableCell>
                    {method.name}
                  </TableCell>
                  <TableCell>
                    {method.description}
                  </TableCell>
                  <TableCell>
                    {method.title}
                  </TableCell>
                  <TableCell>
                    <Chip
                      label={method.layer}
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

MethodsTable.propTypes = {
  methods: PropTypes.array.isRequired
};
