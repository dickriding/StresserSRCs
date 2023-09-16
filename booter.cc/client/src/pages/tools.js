import { useState, useEffect } from 'react';
import { Helmet } from 'react-helmet';
import { useFormik } from 'formik';
import * as Yup from 'yup';
import {
  Box,
  Button,
  Card,
  Container,
  FormHelperText,
  Grid,
  TextField,
  Typography,
  MenuItem
} from '@material-ui/core';
import Axios from '../handler/axios';
import axios from 'axios';
import LoadingScreen from 'react-loading-screen';
import authenticate from '../handler/authenticate';
import { ToastContainer, toast } from 'react-toastify';
import { getTime } from 'date-fns';

import Map from '../components/map';

const currentTools = [
  {
    name: 'Lookup',
    value: 'lookup',
    dis: false
  },
  {
    name: 'Port-scan',
    value: 'portscan',
    dis: true
  },
  {
    name: 'Cloudflare resolver',
    value: 'resolver',
    dis: false
  },
  {
    name: 'Directory scan',
    value: 'dirbuster', 
    dis: true
  }
]
export const Tools = () => {
  const [msg, setMsg] = useState('none')
  const [results, setResults] = useState({})
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
  const formik = useFormik({
    initialValues: {
      tool: '',
      host : ''
    },
    validationSchema: Yup.object().shape({
      tool: Yup.string().required('Tool is required'),
      host: Yup.string().max(255).required('Target host is required')
    }),
    onSubmit: async (values, helpers) => {
      try {
        setMsg('loading')
        const token = getTime(new Date())
        switch (values.tool) {
          case 'lookup' :
            const request = await Axios.post(`/tools/lookup/${token}`, 
              values
            )
            if(request.data.success) {
              setResults(request.data.message)
              setMsg('tools')
            } else {
              setMsg('error')
            }

            break;
          case 'portscan' :
            //code 
            break;
          case 'resolver' :
            const request_resolver = await Axios.post(`/tools/resolve/${token}`, 
              values
            )
            if(request_resolver.data.success) {
              setResults(request_resolver.data.message)
              setMsg('resolve')
            } else {
              setMsg('error')
            }
            break;
          default : //nothing
        }
      } catch (err) {
        console.error(err);
        helpers.setStatus({ success: false });
        helpers.setErrors({ submit: err.message });
        helpers.setSubmitting(false);
      }
    }
  });

  return (
    <>
      <Helmet>
        <title>Tools | BOOTER.CC</title>
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
          <Typography
            color="textPrimary"
            sx={{ mb: 3 }}
            variant="h4"
          >
            Tools
          </Typography>
          <Grid
            container
            spacing={3}
          >
            <Grid
              item
              md={8}
              xs={12}
            >
              <Card
                variant="outlined"
                sx={{ p: 3 }}
              >
                <form onSubmit={formik.handleSubmit}>
                  <div>
                    <Grid
                      container
                      spacing={2}
                    >
                      <Grid 
                        item 
                        xs={12}
                      >
                        <Typography
                          color="textPrimary"
                          sx={{ mb: 3 }}
                          variant="h5"
                        >
                          Use with precaution.
                        </Typography>
                      </Grid>
                      <Grid
                        item
                        xs={12}
                      >
                        <TextField
                          error={Boolean(formik.touched.tool && formik.errors.tool)}
                          fullWidth
                          helperText={formik.touched.tool && formik.errors.tool}
                          label="Tool"
                          name="tool"
                          onBlur={formik.handleBlur}
                          onChange={formik.handleChange}
                          select
                          value={formik.values.tool}
                          variant="outlined"
                        >
                          {currentTools.map((c) => (
                            <MenuItem
                              key={c.value}
                              value={c.value}
                              disabled={c.dis ? true : false}
                            >
                              {c.name.toUpperCase()}
                            </MenuItem>
                          ))}
                        </TextField>
                      </Grid>
                      <Grid
                        item
                        xs={12}
                      >
                        <TextField
                          error={Boolean(formik.touched.host && formik.errors.host)}
                          fullWidth
                          helperText={formik.touched.host && formik.errors.host}
                          label="Target host"
                          name="host"
                          onBlur={formik.handleBlur}
                          onChange={formik.handleChange}
                          value={formik.values.host}
                          variant="outlined"
                        />
                      </Grid>
                      {formik.errors.submit && (
                        <Grid
                          item
                          xs={12}
                        >
                          <FormHelperText error>
                            {formik.errors.submit}
                          </FormHelperText>
                        </Grid>
                      )}
                      <Grid
                        item
                        xs={12}
                      >
                        <Button
                          color="primary"
                          size="large"
                          type="submit"
                          variant="contained"
                        >
                          Search
                        </Button>
                      </Grid>
                      <Grid
                        item
                        xs={12}
                      >
                        <Box
                          sx={{
                            backgroundColor: 'background.default',
                            pb: 3,
                            pt: 1
                          }}
                        >
                          {
                            msg === 'loading' && (
                              <Typography
                                color="textSecondary"
                                sx={{ ml : 1 }}
                                variant="body2"
                              >
                                <br />
                                Loading...
                              </Typography>
                            )
                          }
                          {
                            msg === 'none' && (
                              <Typography
                                color="textSecondary"
                                sx={{ ml : 1 }}
                                variant="body2"
                              >
                                <br />
                                Please initiate a search.
                              </Typography>
                            )
                          }
                          {
                            msg === 'error' && (
                              <Typography
                                color="textSecondary"
                                sx={{ ml : 1 }}
                                variant="body2"
                              >
                                <br />
                                An error has occurred.
                                <br />
                                Either there is no results or search failed.
                              </Typography>
                            )
                          }
                          {
                            msg === 'resolve' && results.results.map( (ex) => (
                              <>
                                 <Typography
                                    color="textSecondary"
                                    sx={{ ml : 1 }}
                                    variant="body2"
                                  >
                                    <br />
                                    <br />
                                    <b>IP</b> : {ex.ip} ({ex.location.country_code})
                                    <br />
                                    {
                                      ex.protocols.map( (x) => (
                                        <>({x}) </>
                                      ))
                                    }
                                  </Typography>
                              </>
                            ))
                          }
                          {
                            msg === 'tools' && (
                              <>
                                <Typography
                                  color="textSecondary"
                                  sx={{ ml : 1 }}
                                  variant="body2"
                                >
                                  <br />
                                  <b>========================</b>
                                  <br />
                                  <br />
                                  <b>IP address</b> : {results.query}
                                </Typography>
                                <Typography
                                  color="textSecondary"
                                  sx={{ ml : 1 }}
                                  variant="body2"
                                >
                                  <br />
                                  <b>Country</b> : {results.country} ({results.countryCode})
                                </Typography>
                                <Typography
                                  color="textSecondary"
                                  sx={{ ml : 1 }}
                                  variant="body2"
                                >
                                  <br />
                                  <b>Region</b> : {results.regionName} ({results.region})
                                </Typography>
                                <Typography
                                  color="textSecondary"
                                  sx={{ ml : 1 }}
                                  variant="body2"
                                >
                                  <br />
                                  <b>City</b> : {results.city}
                                </Typography>
                                <Typography
                                  color="textSecondary"
                                  sx={{ ml : 1 }}
                                  variant="body2"
                                >
                                  <br />
                                  <b>ZIP</b> : {results.zip}
                                </Typography>
                                <Typography
                                  color="textSecondary"
                                  sx={{ ml : 1 }}
                                  variant="body2"
                                >
                                  <br />
                                  <b>Latitude & Longitude</b> : [{results.lat}, {results.lon}]
                                </Typography>
                                <Typography
                                  color="textSecondary"
                                  sx={{ ml : 1 }}
                                  variant="body2"
                                >
                                  <br />
                                  <b>Timezone</b> : {results.timezone}
                                </Typography>
                                <Typography
                                  color="textSecondary"
                                  sx={{ ml : 1 }}
                                  variant="body2"
                                >
                                  <br />
                                  <b>ISP & Organization</b> : {results.isp}, {results.org}
                                </Typography>
                                <Typography
                                  color="textSecondary"
                                  sx={{ ml : 1 }}
                                  variant="body2"
                                >
                                  <br />
                                  <b>Association number</b> : {results.as}
                                  <br />
                                  <b>========================</b>
                                </Typography>
                              </>
                            )
                          }
                        </Box>
                      </Grid>
                    </Grid>
                  </div>
                </form>
              </Card>
            </Grid>
            <Grid
              item
              md={4}
              xs={12}
            >
              {
                msg === 'tools' && (
                  <Map lat={results.lat} lng={results.lon}/>
                )
              }
            </Grid>
          </Grid>
        </Container>
      </Box>
      <ToastContainer />
      </LoadingScreen>
    </>
  );
};