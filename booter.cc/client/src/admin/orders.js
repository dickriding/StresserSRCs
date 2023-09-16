import { useState, useEffect, useCallback } from 'react';
import ACPDialogSelector from "../components/acp-dialog-selector";
import { Helmet } from 'react-helmet';
import Axios from '../handler/axios';
import { Box, Button, Card, Grid, Container, Divider, TablePagination, Typography } from '@material-ui/core';
import { OrdersTable } from '../components/acporders-table';
import { TokensTable } from '../components/acptokens-table';
import { SummaryItem } from '../components/reports/summary-item';
import LoadingScreen from 'react-loading-screen';
import authenticate2 from '../handler/authenticate2';

import { Cash as CashIcon } from '../icons/cash';
import { Paid as PaidIcon } from '../icons/paid';
import { ShoppingCart as ShoppingCartIcon } from '../icons/shopping-cart';

import { getTime } from 'date-fns';

export const OrdersACP = () => {
  const [curStats, setStats] = useState([
    {
      content: null,
      icon: null,
      label: null
    }
  ])
  const [loading, setLoading] = useState(true)
  const [curOrders, setOrders] = useState([]);
  const [curTokens, setTokens] = useState([]);

  useEffect( () => {
    async function fetchData() {
      const authRequest = await authenticate2()
      if(!authRequest)
        window.location.href = '/404'
      else {
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
          setLoading(false)
        }
      }
    }
    fetchData();
  }, [])
  const [rowsPerPage, setRowsPerPage] = useState(5);
  const [page, setPage] = useState(0);

  const [rowsPerPage2, setRowsPerPage2] = useState(5);
  const [page2, setPage2] = useState(0);

  const [dialogOpen, setDialogOpen] = useState(null);

  const openAddTokenDialog = useCallback(() => {
    setDialogOpen("addToken");
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
        <title>ACP - Orders | BOOTER.CC</title>
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
                Panel overview
              </Typography>
            </Grid>
            {curStats.map((item) => (
              <Grid
                item
                key={item.label}
                md={4}
                xs={12}
              >
                <SummaryItem
                  content={item.content}
                  icon={item.icon}
                  label={item.label}
                />
              </Grid>
            ))}
          </Grid>
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
              Orders
            </Typography>
          </Box>
          <Card variant="outlined">
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
              Tokens
            </Typography>
            <Box sx={{ flexGrow: 1 }} />
            <Button
              color="primary"
              onClick={openAddTokenDialog}
              size="small"
              variant="contained"
              sx={{
                mr: 1
              }}
            >
              CREATE TOKEN
            </Button>
          </Box>
          <Card variant="outlined">
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
