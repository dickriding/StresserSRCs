import { useState, useEffect, useCallback } from 'react';
import DialogSelector from "../components/dialog-selector";
import { Helmet } from 'react-helmet';
import Axios from '../handler/axios';
import { Box, Button, Card, Container, CardHeader, Divider, TablePagination, Typography } from '@material-ui/core';
import { TokensTable } from '../components/tokens-table';
import LoadingScreen from 'react-loading-screen';
import authenticate from '../handler/authenticate';
import { getTime } from 'date-fns';

export const Tokens = () => {
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

  const [curTokens, setTokens] = useState([]);

  const fetchData = async () => {
    const token = getTime(new Date())
    const request = await Axios.get(`/payhub/getTokens/${token}`)
    if(request.data.success) {
      let currTokens = request.data.message
      currTokens.sort(function (a, b) {
          return b.usedAt.localeCompare(a.usedAt);
      });
      setTokens(currTokens)
    }
  }
  useEffect( () => {
    fetchData()
  }, [])

  return (
    <>
      <Helmet>
        <title>Tokens | BOOTER.CC</title>
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
              Tokens
            </Typography>
          </Box>
          <Card variant="outlined">
            <CardHeader 
              action={(
                <Button
                  color="primary"
                  onClick={openRedeemDialog}
                  size="small"
                  variant="contained"
                >
                  REDEEM
                </Button>
              )}
              title="My tokens"
            />
            <Divider />
            <TokensTable tokens={curTokens.slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage)} />
            <Divider />
            <TablePagination
              rowsPerPageOptions={[5, 10, 25]}
              component="div"
              count={curTokens.length}
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
