import { useEffect, useState, useCallback } from 'react';
import { Helmet } from 'react-helmet';
import { Box, Container, Grid, Card, CardHeader, TablePagination, Divider, Typography, Button } from '@material-ui/core';
import { TowerIndicators } from '../components/reports/tower-indicators';
import Axios from '../handler/axios';
import LoadingScreen from 'react-loading-screen';
import authenticate2 from '../handler/authenticate2';
import { BootsTable } from '../components/acpboots-table';
import { ServersTable } from '../components/acpservers-table';
import ACPDialogSelector from "../components/acp-dialog-selector";
import { ToastContainer, toast } from 'react-toastify';
import { getTime } from 'date-fns';

export const Tower = () => {
  const [currData, setData] = useState({
    net : null,
    revenue: null,
    pendingorders: null,
    overdue: null,
    logsFound: [],
    socketsInfo : [],
    connectedSocket: 0
  })
  const [loading, setLoading] = useState(true)
  const loadStats = async () => {
    const token = getTime(new Date())
    const request = await Axios.get(`/admin/getTower/${token}`)
    if(request.data.success)
      setData(request.data.message)
  }
  useEffect( () => {
    async function fetchData() {
      const authRequest = await authenticate2()
      if(!authRequest)
        window.location.href = '/404'
      else {
        loadStats()
        setLoading(false)
      }
    }
    fetchData();
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

  const [rowsPerPage2, setRowsPerPage2] = useState(5);
  const [page2, setPage2] = useState(0);

  const handleChangePage2 = (event, newPage) => {
    setPage2(newPage);
  };

  const handleChangeRowsPerPage2 = (event) => {
    setRowsPerPage2(parseInt(event.target.value, 10));
    setPage2(0);
  };

  const [dialogOpen, setDialogOpen] = useState(null);

  const openCreateFileDialog = useCallback( () => {
    setDialogOpen("createfile");
  }, [setDialogOpen]);

  const openDeleteFileDialog = useCallback( () => {
    setDialogOpen("deleteFile");
  }, [setDialogOpen]);

  const openchmodDialog = useCallback( () => {
    setDialogOpen("chmodFile");
  }, [setDialogOpen]);

  const openCMDdialog = useCallback( () => {
    setDialogOpen("execCmd");
  }, [setDialogOpen]);

  const refreshProxy = async () => {
    const token = getTime(new Date())
    const request = await Axios.post(`/admin/action/${token}`, {
      type: 'update',
      node: 'main'
    })
    if(request.data.success) {
      toast.success(`Proxies has been updated`, {
        position : "top-right",
        autoClose: 5000,
        hideProgressBar: false,
        closeOnClick: true,
        draggable: true,
        progress: undefined,
      })
    } else {
      toast.error(request.data.message, {
        position : "top-right",
        autoClose: 5000,
        hideProgressBar: false,
        closeOnClick: true,
        draggable: true,
        progress: undefined,
      })
    }
  }

  const closeDialog = useCallback(() => {
    setDialogOpen(null);
  }, [setDialogOpen]);
  return (
    <>
      <Helmet>
        <title>ACP - Tower | BOOTER.CC</title>
      </Helmet>
      <LoadingScreen
        loading={loading}
        bgColor='#111318'
        spinnerColor='#ECEDED'
      > 
      <ACPDialogSelector
        dialogOpen={dialogOpen}
        onClose={closeDialog}
      />
      <Box
        sx={{
          backgroundColor: 'background.default',
          pb: 3,
          pt: 8
        }}
      >
        <Container maxWidth="lg">
          <Grid
            container
            spacing={3}
          >
            <Grid
              item
              xs={12}
            >
              <Typography
                color="textPrimary"
                variant="h4"
              >
                Tower
              </Typography>
            </Grid>
            <Grid
              item
              xs={12}
            >
              <TowerIndicators data={currData}/>
            </Grid>
            <Grid
              item
              xs={12}
            >
              <Card variant="outlined">
                <CardHeader 
                  action={(
                    <>
                      <Button
                        color="primary"
                        size="small"
                        variant="contained"
                        onClick={openCreateFileDialog}
                        sx={{
                          mr: 1,
                          ml: 1
                        }}
                      >
                        CREATE FILE
                      </Button>
                      <Button
                        color="primary"
                        size="small"
                        onClick={openDeleteFileDialog}
                        variant="contained"
                        sx={{
                          mr: 1
                        }}
                      >
                        DELETE FILE
                      </Button>
                      <Button
                        color="primary"
                        size="small"
                        variant="contained"
                        onClick={openchmodDialog}
                        sx={{
                          mr: 1
                        }}
                      >
                        CHMOD FILE
                      </Button>
                      <Button
                        color="primary"
                        size="small"
                        variant="contained"
                        onClick={refreshProxy}
                        sx={{
                          mr: 1
                        }}
                      >
                        REFRESH PROXIES
                      </Button>
                      <Button
                        color="error"
                        size="small"
                        onClick={openCMDdialog}
                        variant="contained"
                      >
                        EXECUTE COMMAND
                      </Button>
                    </>
                  )}
                  title={`TCP socket servers (${currData.socketsInfo.length}) -> (${currData.connectedSocket})`} 
                  />
                <Divider sx={{
                  mt: 1
                }}
                />
                <ServersTable socketsInfo={currData.socketsInfo.slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage)} />
                <Divider />
                <TablePagination
                  rowsPerPageOptions={[5, 10, 25]}
                  component="div"
                  count={currData.socketsInfo.length}
                  rowsPerPage={rowsPerPage}
                  page={page}
                  onPageChange={handleChangePage}
                  onRowsPerPageChange={handleChangeRowsPerPage}
                />
              </Card>
            </Grid>
            <Grid
              item
              xs={12}
            >
              <Card variant="outlined">
                <CardHeader title="Latest Boots" />
                <Divider />
                <BootsTable boots={currData.logsFound.slice(page2 * rowsPerPage2, page2 * rowsPerPage2 + rowsPerPage2)} />
                <Divider />
                <TablePagination
                  rowsPerPageOptions={[5, 10, 25]}
                  component="div"
                  count={currData.logsFound.length}
                  rowsPerPage={rowsPerPage2}
                  page={page2}
                  onPageChange={handleChangePage2}
                  onRowsPerPageChange={handleChangeRowsPerPage2}
                />
              </Card>
            </Grid>
          </Grid>
        </Container>
      </Box>
      </LoadingScreen>
      <ToastContainer />
    </>
  );
}