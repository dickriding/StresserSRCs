import PropTypes from 'prop-types';
import { useEffect } from 'react';
import { format, getTime } from 'date-fns';
import {
  Box,
  Chip,
  Table,
  TableBody,
  TableCell,
  TableHead,
  TableRow,
  Typography,
  IconButton
} from '@material-ui/core';
import { Stop as StopIcon } from '../icons/stop';
import { Play as PlayIcon } from '../icons/play';
import { Scrollbar } from './scrollbar';
import Axios from '../handler/axios';
import Countdown from 'react-countdown';
import { ToastContainer, toast } from 'react-toastify';

export const BootsTable = (props) => {
  const { boots, getBoots } = props;

  const onStop = (event, attackId) => {
    event.preventDefault()
    const token = getTime(new Date())
    Axios.post(`/stopAttack/${token}`, {
      attackId
    }).then( (r) => {
      if(r.data.success) {
        toast.success(`Your attack has been stopped successfuly.`, {
          position : "top-right",
          autoClose: 5000,
          hideProgressBar: false,
          closeOnClick: true,
          draggable: true,
          progress: undefined,
        })
        getBoots()
      } else {
        toast.error(r.data.message, {
          position : "top-right",
          autoClose: 5000,
          hideProgressBar: false,
          closeOnClick: true,
          draggable: true,
          progress: undefined,
        })
      }
    })
  }
  useEffect( () => {
    getBoots()
  }, [])

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
                Status
              </TableCell>
              <TableCell>
                Action
              </TableCell>
            </TableRow>
          </TableHead>
          <TableBody>
            {boots.map((boot) => {
              if(!boot.stopped) {
                const today = new Date()
                let dt = new Date(boot.time)
                dt.setSeconds( dt.getSeconds() + boot.duration )
                var differenceSec = (dt - today) / 1000
              }
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
                    {boot.destination}({boot.port}) ({boot.method})
                  </TableCell>
                  <TableCell>
                    {
                      boot.looped && !boot.stopped ? (
                        <Chip
                          label='Looping'
                          color='error'
                          variant="outlined"
                        />
                      ) : (
                        <Chip
                          label={boot.stopped ? 'Stopped' : 
                            <Countdown 
                              date={Date.now() + differenceSec * 1000} 
                              onComplete={getBoots}
                              renderer={props => <div>{props.minutes}:{props.seconds}</div>}
                            />
                          }
                          color={boot.stopped ? 'success' : 'warning'}
                          variant="outlined"
                        />
                      )
                    }
                  </TableCell>
                  <TableCell>
                    {
                      boot.stopped ? (
                        <PlayIcon />
                      ) : (
                        <IconButton onClick={ (event) => onStop(event, boot.id)}>
                          <StopIcon />
                        </IconButton>
                      )
                    }
                  </TableCell>
                </TableRow>
              );
            })}
          </TableBody>
        </Table>
      </Scrollbar>
      <ToastContainer />
    </div>
  );
};

BootsTable.propTypes = {
  boots: PropTypes.array.isRequired,
  getBoots: PropTypes.func.isRequired
};
