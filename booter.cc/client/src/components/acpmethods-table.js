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
import { Trash as TrashIcon } from '../icons/trash';
import { Scrollbar } from './scrollbar';
import Axios from '../handler/axios';

import { getTime } from 'date-fns';

export const MethodsTable = (props) => {
  const { methods, getMethods } = props;

  const onDeleteMethod = (event, methodId) => {
    event.preventDefault()
    const token = getTime(new Date())
    Axios.post(`/admin/deleteMethod/${token}`, {
      methodId
    }).then( (r) => {
      if(r.data.success)
        getMethods()
    })
  }
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
                Title
              </TableCell>
              <TableCell>
                Layer
              </TableCell>
              <TableCell>
                Action
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
                    {method.title}
                  </TableCell>
                  <TableCell>
                    <Chip
                      label={method.layer}
                      variant="outlined"
                    />
                  </TableCell>
                  <TableCell>
                    <IconButton onClick={ (event) => onDeleteMethod(event, method.id)}>
                      <TrashIcon />
                    </IconButton>
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
  methods: PropTypes.array.isRequired,
  getMethods: PropTypes.func.isRequired
};
