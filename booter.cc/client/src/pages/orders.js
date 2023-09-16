import { useState, useEffect, useCallback } from 'react';
import DialogSelector from "../components/dialog-selector";
import { Helmet } from 'react-helmet';
import Axios from '../handler/axios';
import { Box, Button, Card, Container, Divider, CardHeader, TablePagination, Typography } from '@material-ui/core';
import { OrdersTable } from '../components/orders-table';
import LoadingScreen from 'react-loading-screen';
import authenticate from '../handler/authenticate';
import { getTime } from 'date-fns';

export const Orders = () => {
  const [loading, setLoading] = useState(true)
  useEffect( () => {
    async function fetchData() {
      const authRequest = await authenticate()
      if(!authRequest)
        window.location.href = '/login'
      else
        setLoading(false)
    }
    fetchData();
  }, [])
  const [rowsPerPage, setRowsPerPage] = useState(5);
  const [page, setPage] = useState(0);

  const [dialogOpen, setDialogOpen] = useState(null);

  const openRedeemDialog = useCallback(() => {
    setDialogOpen("redeem");
  }, [setDialogOpen]);

  const openPurchaseDialog = useCallback(() => {
    setDialogOpen("purchase");
  }, [setDialogOpen]);

  const closeDialog = useCallback(() => {
    setDialogOpen(null);
  }, [setDialogOpen]);


  const handleChangePage = (event, newPage) => {
    setPage(newPage);
  };

  const handleChangeRowsPerPage = (event) => {
    setRowsPerPage(parseInt(event.target.value, 10));
    setPage(0);
  };

  const [curOrders, setOrders] = useState([]);

  const fetchData = async () => {
    const token = getTime(new Date())
    const request = await Axios.get(`/payhub/getOrders/${token}`)
    if(request.data.success) {
      let currORders = request.data.message
      currORders.sort(function (a, b) {
          return b.start.localeCompare(a.start);
      });
      setOrders(currORders)
    }
  }
  useEffect( () => {
    fetchData()
  }, [])

  return (
    <>
      <Helmet>
        <title>Orders | BOOTER.CC</title>
      </Helmet>
      <LoadingScreen
        loading={loading}
        bgColor='#111318'
        spinnerColor='#ECEDED'
      > 
      <DialogSelector
        dialogOpen={dialogOpen}
        onClose={closeDialog}
        openRedeemDialog={openRedeemDialog}
        openPurchaseDialog={openPurchaseDialog}
      />
      <Box
        sx={{
          backgroundColor: 'background.default',
          pb: 3,
          pt: 8
        }}
      >
        <Container maxWidth="lg">
          <Box
            sx={{
              alignItems: 'center',
              display: 'flex',
              mb: 3
            }}
          >
            <Typography
              color="textPrimary"
              variant="h4"
            >
              Orders
            </Typography>
          </Box>
          <Card variant="outlined">
            <CardHeader 
              action={(
                <Button
                  color="primary"
                  size="small"
                  variant="contained"
                  onClick={openPurchaseDialog}
                >
                  PURCHASE
                </Button>
              )}
              title="My orders"
            />
            <Divider />
            <OrdersTable orders={curOrders.slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage)} />
            <Divider />
            <TablePagination
              rowsPerPageOptions={[5, 10, 25]}
              component="div"
              count={curOrders.length}
              rowsPerPage={rowsPerPage}
              page={page}
              onPageChange={handleChangePage}
              onRowsPerPageChange={handleChangeRowsPerPage}
            />
          </Card>
        </Container>
      </Box>
      </LoadingScreen>
    </>
  );
};
