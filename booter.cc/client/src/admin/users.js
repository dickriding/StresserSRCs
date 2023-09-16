import { useState, useEffect } from 'react';
import { Helmet } from 'react-helmet';
import Axios from '../handler/axios';
import { Box, Card, Container, Divider, TablePagination, Typography } from '@material-ui/core';
import { UsersFilter } from '../components/users/users-filter';
import { UsersTable } from '../components/users-table';
import LoadingScreen from 'react-loading-screen';
import authenticate2 from '../handler/authenticate2';
import { getTime } from 'date-fns';

export const Users = () => {
  const [curUsers, setUsers] = useState([]);
  const [filteredUsers, filterUser] = useState([])
  const [loading, setLoading] = useState(true)

  useEffect( () => {
    async function fetchData() {
      const authRequest = await authenticate2()
      if(!authRequest)
        window.location.href = '/404'
      else {
        const token = getTime(new Date())
        const request = await Axios.get(`/admin/getUsers/${token}`)
        if(request.data.success) {
          setUsers(request.data.message)
          filterUser(request.data.message)
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
  const [query, setQuery] = useState('');

  const handleQueryChange = (newQuery) => {
    if(!newQuery || newQuery.length === 0 || newQuery === '')
      newQuery = ''
    const filtered = curUsers.filter(user => {
      return user.username.toLowerCase().includes(newQuery.toLowerCase())
    })
    setQuery(newQuery);
    filterUser(filtered);
  };

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
        <title>ACP - Users | BOOTER.CC</title>
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
              Users
            </Typography>
          </Box>
          <Card variant="outlined">
            <UsersFilter
              onQueryChange={handleQueryChange}
              query={query}
            />
            <Divider />
            <UsersTable users={filteredUsers.slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage)} />
            <Divider />
            <TablePagination
              rowsPerPageOptions={[5, 10, 25]}
              component="div"
              count={filteredUsers.length}
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
