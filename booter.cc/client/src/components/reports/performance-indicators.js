import { useState, useEffect, useCallback } from 'react';
import { BootsTable } from '../boots-table';
import Axios from '../../handler/axios';
import DialogSelector2 from "../dialog-selector2";
import { format, getTime } from 'date-fns';
import {
  Box,
  Card,
  CardContent,
  CardHeader,
  Divider,
  Typography,
  Container,
  Button,
  TablePagination,
  Grid
} from '@material-ui/core';

export const PerformanceIndicators = (props) => {
    const [stats, setStats] = useState([
    {
      content: 'No',
      label: 'Subscibed'
    },
    {
      content: '0/0',
      label: 'Concurrents'
    },
    {
      content: '0/0',
      label: 'Boots today'
    },
    {
      content: '0',
      label: 'Maximum Time'
    },
    {
      content: 'No',
      label: 'API access'
    }
  ])
  const [data, setData] = useState({
    "maxTime" : 3600,
    "isLoop" : false,
    "availableMethods": [
        {
            "id": "r01IOzAqE1o8smSS",
            "layer": 7,
            "name": "UAM JS BYPASS",
            "headers": true,
            "postdata": true,
            "http": true,
            "option" : false,
            "getquery" : false,
            "cookie" : false,
        }
    ],
    "proxiesList": [
        {
            "name": "Default",
            "code": 0,
            "file": "default.txt",
            "file_http": "default_http.txt"
        }
    ]
  });
  const [dialogOpen, setDialogOpen] = useState(null);
  const [boots, changeBoots] = useState([])
  const openAttackDialog = useCallback(() => {
    setDialogOpen("atk");
  }, [setDialogOpen]);

  const openLoopDialog = useCallback(() => {
    setDialogOpen("loop");
  }, [setDialogOpen]);

  const closeDialog = useCallback(() => {
    setDialogOpen(null);
  }, [setDialogOpen]);

  const fetchData = async () => {
    const token = getTime(new Date())
    const request = await Axios.get(`/data/${token}`)
    if(request.data.success) {
      setData(request.data.message)
      setStats([
        {
          content: request.data.message.isSubbed ? `${format(new Date(request.data.message.subEnds), 'dd MMM yyyy')}` : 'No',
          label: 'Subscibed'
        },
        {
          content: `${request.data.message.currentConcurrent}/${request.data.message.maxConcurrent}`,
          label: 'Concurrents'
        },
        {
          content: request.data.message.isSubbed ? 'Unlimited' : `${request.data.message.currentBoots}/${request.data.message.maxBoots}`,
          label: 'Boots today'
        },
        {
          content: request.data.message.maxTime,
          label: 'Maximum Time'
        },
        {
          content: request.data.message.hasAPI ? 'Yes' : 'No',
          label: 'API access'
        }
      ])
    }
  }

  const getBoots = async () => {
    const token = getTime(new Date())
    const request = await Axios.get(`/panel/history/${token}`)
    if(request.data.success) {
      let currBoots = request.data.message
      currBoots.sort(function (a, b) {
          return b.time.localeCompare(a.time);
      });
      changeBoots(currBoots)
    }
    fetchData()
  }

  useEffect( () => {
    getBoots()
  }, [])

  const [rowsPerPage, setRowsPerPage] = useState(5);
  const [page, setPage] = useState(0);

  const handleChangePage = (event, newPage) => {
    setPage(newPage);
  };

  const handleChangeRowsPerPage = (event) => {
    setRowsPerPage(parseInt(event.target.value, 10));
    setPage(0);
  };

  return (
    <Card
      variant="outlined"
      {...props}
    >
      <DialogSelector2
        dialogOpen={dialogOpen}
        onClose={closeDialog}
        getBoots={getBoots}
        openAttackDialog={openAttackDialog}
        data={data}
      />
      <CardHeader 
        action={(
          <Grid
            container 
          >
            {
              data.isLoop && (
                <Button
                  color="warning"
                  size="small"
                  variant="contained"
                  onClick={openLoopDialog}
                >
                  LOOP
                </Button>
              )
            }
            <Button
              color="primary"
              size="small"
              variant="contained"
              onClick={openAttackDialog}
              sx={{
                ml: 1
              }}
            >
              NEW ATTACK
            </Button>
          </Grid>
        )}
        title="Panel"
      />
      <Divider />
      <CardContent>
        <Box
          sx={{
            gap: 3,
            display: 'grid',
            gridTemplateColumns: {
              md: 'repeat(5, 1fr)',
              sm: 'repeat(2, 1fr)',
              xs: 'repeat(1, 1fr)'
            }
          }}
        >
          {stats.map((item) => (
            <Card
              elevation={0}
              key={item.label}
              variant="outlined"
              sx={{
                alignItems: 'center',
                borderRadius: 1,
                p: 2
              }}
            >
              <Typography
                variant="overline"
              >
                {item.label}
              </Typography>
              <Typography
                color="textSecondary"
                variant="h6"
              >
                {item.content}
              </Typography>
            </Card>
          ))}
        </Box>
        <Box
          sx={{
            backgroundColor: 'background.default',
            pb: 3,
            pt: 3
          }}
        >
          <BootsTable boots={boots.slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage)} getBoots={getBoots}/>
          <Divider />
          <TablePagination
            rowsPerPageOptions={[5, 10, 25]}
            component="div"
            count={boots.length}
            rowsPerPage={rowsPerPage}
            page={page}
            onPageChange={handleChangePage}
            onRowsPerPageChange={handleChangeRowsPerPage}
          />
        </Box>
      </CardContent>
    </Card>
  );
};
