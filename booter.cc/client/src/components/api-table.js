import PropTypes from 'prop-types';
import {
  Chip,
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableRow,
  Typography
} from '@material-ui/core';
import { Scrollbar } from './scrollbar';
import Axios from '../handler/axios';

const apiData = [
  {
    param : 'key',
    required: true,
    description : 'Your API key provided above. (STRING)'
  },
  {
    param : 'host',
    required: true,
    description : 'Target host and/or destination. (STRING)'
  },
  {
    param : 'port',
    description : 'Target port, must be positive and range between 1 and 65,535. (NUMBER)'
  },
  {
    param : 'time',
    required: true,
    description : 'Attack duration, must be positive and does not exceed your plan\'s limit. (NUMBER)'
  },
  {
    param : 'method',
    required: true,
    description : 'Method that is going to be used, must one of the following API values downn below. (STRING)'
  },
  {
    param : 'proxy',
    description : 'Proxy that are going to be used, default is 0. (NUMBER)\n',
    options : [
      '0 - Global',
      '1 - Asia',
      '2 - Europe',
      '3 - North America',
      '4 - South Korea',
      '5 - China'
      ]
  }
]
export const ApiTable = (props) => {
  return (
    <div>
      <Scrollbar>
        <Table>
          <TableHead>
            <TableRow>
              <TableCell align="right">
                Param
              </TableCell>
              <TableCell>
                Description
              </TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {apiData.map((dat) => {
              return (
                <TableRow key={dat.param}>
                  <TableCell align="right">
                    {dat.param}
                    {
                      dat.required && (
                        <>
                          <br />
                          <Typography
                            color="warning"
                            variant="caption"
                          >
                            required
                          </Typography>
                        </>
                      )
                    }
                  </TableCell>
                  <TableCell>
                    {dat.description}
                    {
                      dat.options && (
                        <>
                          {
                            dat.options.map( (e) => (
                              <Typography
                                variant="caption"
                              >
                                <br />
                                {e}
                              </Typography>
                            ))
                          }
                        </>
                      )
                    }
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