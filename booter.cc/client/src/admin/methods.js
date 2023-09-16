import { useState, useEffect } from 'react';
import { Helmet } from 'react-helmet';
import Axios from '../handler/axios';
import { Box, Card, Container, Divider, TablePagination, Typography } from '@material-ui/core';
import { MethodsTable } from '../components/acpmethods-table';
import LoadingScreen from 'react-loading-screen';
import authenticate2 from '../handler/authenticate2';
import AddMethod from '../components/add-method';
import { getTime } from 'date-fns';

export const Methods = () => {
  const [curMethods, setMethods] = useState([]);
  const [loading, setLoading] = useState(true)
  const getMethods = async () => {
    const token = getTime(new Date())
    const request = await Axios.get(`/admin/getMethod/${token}`)
    if(request.data.success)
      setMethods(request.data.message)
  }
  useEffect( () => {
    async function fetchData() {
      const authRequest = await authenticate2()
      if(!authRequest)
        window.location.href = '/404'
      else {
        const token = getTime(new Date())
        const request = await Axios.get(`/admin/getMethod/${token}`)
        if(request.data.success) {
          setMethods(request.data.message)
          setLoading(false)
        } else {
          window.location.href = '/404'
        }
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

  return (
    <>
      <Helmet>
        <title>ACP - Methods | BOOTER.CC</title>
      </Helmet>
      <LoadingScreen
        loading={loading}
        bgColor='#111318'
        spinnerColor='#ECEDED'
      > 
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
              Manage methods
            </Typography>
          </Box>     
          <AddMethod />    
          <Card 
            variant="outlined"
            sx={{
              mt: 3
            }}
          >
            <MethodsTable 
              methods={curMethods.slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage)} 
              getMethods={getMethods}
            />
            <Divider />
            <TablePagination
              rowsPerPageOptions={[5, 10, 25]}
              component="div"
              count={curMethods.length}
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
