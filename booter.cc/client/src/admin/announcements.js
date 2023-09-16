import { useState, useEffect, useCallback } from 'react';
import ACPDialogSelector from "../components/acp-dialog-selector";
import { Helmet } from 'react-helmet';
import Axios from '../handler/axios';
import { Box, Button, Card, Grid, Container, Divider, CardHeader, TablePagination, Typography } from '@material-ui/core';
import { TokensTable } from '../components/acptokens-table';
import LoadingScreen from 'react-loading-screen';
import authenticate2 from '../handler/authenticate2';

import { getTime } from 'date-fns';

export const AnnouncementACP = () => {
  const [loading, setLoading] = useState(true)
  const [curTokens, setTokens] = useState([]);

  useEffect( () => {
    async function fetchData() {
      const authRequest = await authenticate2()
      if(!authRequest)
        window.location.href = '/404'
      else {
        /*
        const token = getTime(new Date())
        const request = await Axios.get(`/admin/getOrders/${token}`)
        if(request.data.success) {
          setOrders(request.data.message.currentOrders)
          setTokens(request.data.message.currentTokens)
          setStats([
            {
              content: request.data.message.totalOrders,
              icon: ShoppingCartIcon,
              label: 'Total Orders'
            },
            {
              content: request.data.message.paidOrders,
              icon: PaidIcon,
              label: 'Paid Orders'
            },
            {
              content: request.data.message.totalPrice,
              icon: CashIcon,
              label: 'Income ($)'
            }
          ])
          */
          setLoading(false)
          /*
        }*/
      }
    }
    fetchData();
  }, [])

  const [rowsPerPage2, setRowsPerPage2] = useState(5);
  const [page2, setPage2] = useState(0);

  const [dialogOpen, setDialogOpen] = useState(null);

  const openAddTokenDialog = useCallback(() => {
    setDialogOpen("addNotification");
  }, [setDialogOpen]);

  const closeDialog = useCallback(() => {
    setDialogOpen(null);
  }, [setDialogOpen]);

  const handleChangePage2 = (event, newPage) => {
    setPage2(newPage);
  };

  const handleChangeRowsPerPage2 = (event) => {
    setRowsPerPage2(parseInt(event.target.value, 10));
    setPage2(0);
  };

  return (
    <>
      <Helmet>
        <title>Notifications - Orders | BOOTER.CC</title>
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
          <Box
            sx={{
              alignItems: 'center',
              display: 'flex',
              mt: 3,
              mb: 3
            }}
          >
            <Typography
              color="textPrimary"
              variant="h5"
            >
              Notifications
            </Typography>
          </Box>
          <Card variant="outlined">
            <CardHeader
              action={(
                <Button
                  color="primary"
                  onClick={openAddTokenDialog}
                  size="small"
                  variant="contained"
                  sx={{
                    mr: 1
                  }}
                >
                  PUSH
                </Button>
              )}
              title="Global notifications & announcements"
            />
            <TokensTable tokens={curTokens.slice(page2 * rowsPerPage2, page2 * rowsPerPage2 + rowsPerPage2)} />
            <Divider />
            <TablePagination
              rowsPerPageOptions={[5, 10, 25]}
              component="div"
              count={curTokens.length}
              rowsPerPage={rowsPerPage2}
              page={page2}
              onPageChange={handleChangePage2}
              onRowsPerPageChange={handleChangeRowsPerPage2}
            />
          </Card>
        </Container>
      </Box>
      </LoadingScreen>
    </>
  );
};
