import { useEffect, useState } from 'react';
import { Helmet } from 'react-helmet';
import {
  useParams
} from "react-router-dom";
import { 
  Box,
  Card,
  Container,
  Grid,
  Typography,
  Avatar,
  TextField,
  MenuItem,
  FormHelperText,
  Button,
  Slider,
  Chip
} from '@material-ui/core';
import { format, getTime } from 'date-fns';
import Axios from '../handler/axios';
import { useFormik } from 'formik';
import * as Yup from 'yup';
import LoadingScreen from 'react-loading-screen';
import authenticate2 from '../handler/authenticate2';

export const User = () => {
  const [currStats, setStats] = useState([
    {
      content: '0/0',
      label: 'Concurrent'
    },
    {
      content: '0/0',
      label: 'Boots'
    },
    {
      content: '0',
      label: 'Time'
    },
    {
      content: 'No',
      label: 'Loop'
    },
    {
      content: 'No',
      label: 'API'
    }
  ])
  const [loading, setLoading] = useState(true)
  const [currentUser, setUser] = useState({
    username : null,
    email : null,
    concurrent : 1,
    maxBoots : 1,
    maxTime : 1,
    api_access : false,
    loop : false,
    date : null,
    subbed : null,
    subEnds : null,
    banned : false,
    admin : null
  })
  const [currentSession, setSessions] = useState([])
  const { id } = useParams();
  const fetchAll = async () => {
    const authRequest = await authenticate2()
    if(!authRequest) {
      window.location.href = '/404'
    } else {
      const token = getTime(new Date())
      const request = await Axios.get(`/admin/getUser/${token}/${id}`)
      if(request.data.success) {
        setUser(request.data.message.userFound)
        setStats([
          {
            content: request.data.message.userFound.concurrent,
            label: 'Concurrent'
          },
          {
            content: request.data.message.userFound.maxBoots,
            label: 'Boots'
          },
          {
            content: request.data.message.userFound.maxTime,
            label: 'Time'
          },
          {
            content: request.data.message.userFound.loop ? 'Yes' : 'No',
            label: 'Loop'
          },
          {
            content: request.data.message.userFound.api_access ? 'Yes' : 'No',
            label: 'API'
          }
        ])
        setSessions(request.data.message.sessionFound)
        setLoading(false)
      } else {
        window.location.href = '/404'
      }
    } 
  }
  useEffect( () => {
    fetchAll()
  }, [])
  const formik = useFormik({
    initialValues: {
      maxTime : 360,
      maxConcurrent: 1,
      duration : 1,
      api_access : false,
      loop_access : false
    },
    validationSchema: Yup.object().shape({
      maxTime : Yup.number().min(360).max(10000).required('Time is required.'),
      maxConcurrent : Yup.number().positive().max(10).required('Max concurrent is required.'),
      duration : Yup.number().positive().max(24).required('Duration is required.'),
      api_access : Yup.boolean().required('API access is required.'),
      loop_access: Yup.boolean().required('Loop access is requried.')
    }),
    onSubmit: async (values, helpers) => {
      try {
        const token = getTime(new Date())
        const request = await Axios.post(`/admin/updateUser/${token}/${id}`, 
          values
        )
        if(request.data.success) {
          helpers.setStatus({ success: true });
          helpers.setSubmitting(false);
          window.location.href = `/super-secret-acp/user/${id}`
        }
        else {
          helpers.setStatus({ success: false });
          helpers.setErrors({ submit: request.data.message });
          helpers.setSubmitting(false);
        }
      } catch (err) {
        console.error(err);
        helpers.setStatus({ success: false });
        helpers.setErrors({ submit: err.message });
        helpers.setSubmitting(false);
      }
    }
  });
  const handleBanUser = async () => {
    const token = getTime(new Date())
    const request = await Axios.post(`/admin/banUser/${token}`, {
      username: id
    })
    if(request.data.success)
      window.location.href = `/super-secret-acp/user/${id}`
  }
  const handleStripUser = async () => {
    const token = getTime(new Date())
    const request = await Axios.post(`/admin/stripUser/${token}`, {
      username: id
    })
    if(request.data.success)
      window.location.href = `/super-secret-acp/user/${id}`
  }
  const handleDeleteAccount = async () => {
    const token = getTime(new Date())
    const request = await Axios.post(`/admin/deleteAccount/${token}`, {
      username: id
    })
    if(request.data.success)
      window.location.href = `/super-secret-acp/users`
  }
  return(
    <>
      <Helmet>
        <title>ACP - {id} | BOOTER.CC</title>
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
            User Panel
          </Typography>
          <Grid
            container
          >
            <Grid
              item
              md={8}
              xs={12}
            >
              <Card
                sx={{
                  display: 'grid',
                  gap: 3,
                  gridAutoFlow: 'row',
                  p: 3
                }}
                variant="outlined"
              >
                <div>
                  <Box
                    sx={{
                      alignItems: 'center',
                      display: 'flex',
                      pb: 3
                    }}
                  >
                    <Avatar
                      src="/static/user-chen_simmons.png"
                      sx={{
                        height: 64,
                        mr: 2,
                        width: 64
                      }}
                    />
                    <div>
                      <Typography
                        color="textPrimary"
                        variant="h5"
                      >
                        {currentUser.username}
                        {
                          currentUser.admin ? (
                            <Chip
                              sx={{
                                ml: 1
                              }}
                              label='Admin'
                              color='primary'
                              variant="outlined"
                              size="small"
                            />
                          ) : ( currentUser.banned ? (
                              <Chip
                                sx={{
                                  ml: 1
                                }}
                                label='Banned'
                                color='error'
                                variant="outlined"
                                size="small"
                              />
                            ) : (
                            currentUser.subbed ? (
                                <Chip
                                  sx={{
                                    ml: 1
                                  }}
                                  label='Paid'
                                  color='secondary'
                                  variant="outlined"
                                  size="small"
                                />
                              ) : ''
                            )
                          )
                        }
                      </ Typography>
                      <Typography
                        color="textSecondary"
                        variant="caption"
                      >
                        {currentUser.email}
                        <br />
                        {format(new Date(currentUser.date), 'dd MMM yyyy')} {format(new Date(currentUser.date), 'HH:mm')}
                      </Typography>
                      <br />
                      {
                        currentUser.subbed ? (
                            <Typography
                                color="textSecondary"
                                variant="caption"
                              >
                            Subscription ends in {format(new Date(currentUser.subEnds), 'dd MMM yyyy')} {format(new Date(currentUser.subEnds), 'HH:mm')}.
                          </Typography>
                        ) : ''
                      }
                    </div>
                  </Box>
                </div>
                <div>
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
                    {currStats.map((item) => (
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
                </div>
                <div>
                  <Typography
                    color="error"
                    variant="h5"
                  >
                    DELETING AN ACCOUNT WILL CAUSE IRRECOVERABLE DAMAGE.
                  </Typography>
                  <Button
                    color="error"
                    size="large"
                    fullWidth
                    type="button"
                    onClick={handleBanUser}
                    disabled={currentUser.admin ? true : false}
                    variant="contained"
                  >
                    { currentUser.banned ? 'UNBANISH' : 'BANISH' }
                  </Button>
                  <Button
                    color="error"
                    size="large"
                    fullWidth
                    type="button"
                    onClick={handleStripUser}
                    variant="contained"
                    sx={{
                        mt: 1
                      }}
                  >
                    STRIP😳
                  </Button>
                  <Button
                    color="error"
                    sx={{
                      mt: 1
                    }}
                    size="large"
                    fullWidth
                    type="button"
                    onClick={handleDeleteAccount}
                    disabled={currentUser.admin ? true : false}
                    variant="contained"
                  >
                    DELETE
                  </Button>
                </div>
              </Card>
              <Card
                sx={{
                  mt: 3,
                  display: 'grid',
                  gap: 3,
                  gridAutoFlow: 'row',
                  p: 3
                }}
                variant="outlined"
              >
                <div>
                  <Typography
                    color="textPrimary"
                    variant="h5"
                  >
                    User sessions:
                  </Typography>
                  {currentSession.map((item) => (
                      <Card
                        elevation={0}
                        key={item.label}
                        sx={{
                          alignItems: 'center',
                          backgroundColor: '#33363A',
                          borderRadius: 1,
                          p: 2,
                          mt: 1,
                        }}
                      >
                        <Typography
                          color="textSecondary"
                          variant="caption"
                        >
                          {format(new Date(item.date), 'dd MMM yyyy')} {format(new Date(item.date), 'HH:mm')}
                           - {item.platform} {item.os} | {item.browser} {item.version}
                        </Typography>
                      </Card>
                    ))}
                </div>
              </Card>
            </Grid>
            <Grid
              item
              md={4}
              xs={12}
              sx={{
                pl: 2
              }}
            >
              <Card
                sx={{
                  display: 'grid',
                  gap: 3,
                  gridAutoFlow: 'row',
                  p: 3
                }}
                variant="outlined"
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
                        <Typography style={{
                          display: 'flex'
                        }} variant="body2" color="textSecondary" paragraph>
                          <div style={{
                            flexGrow : 1
                          }}/>
                          ({formik.values.maxTime}) Seconds(s)
                        </Typography>
                        <Slider
                          error={Boolean(formik.touched.maxTime && formik.errors.maxTime)}
                          fullWidth
                          helperText={formik.touched.maxTime && formik.errors.maxTime}
                          label="Time"
                          name="maxTime"
                          onBlur={formik.handleBlur}
                          onChange={formik.handleChange}
                          value={formik.values.maxTime}
                          variant="outlined"
                          step={1}
                          min={360}
                          max={10000}
                        />
                      </Grid>
                      <Grid
                        item
                        xs={12}
                      >
                        <Typography style={{
                          display: 'flex'
                        }} variant="body2" color="textSecondary" paragraph>
                          <div style={{
                            flexGrow : 1
                          }}/>
                          ({formik.values.maxConcurrent}) Concurrent(s)
                        </Typography>
                        <Slider
                          error={Boolean(formik.touched.maxConcurrent && formik.errors.maxConcurrent)}
                          fullWidth
                          helperText={formik.touched.maxConcurrent && formik.errors.maxConcurrent}
                          label="Concurrent"
                          name="maxConcurrent"
                          onBlur={formik.handleBlur}
                          onChange={formik.handleChange}
                          value={formik.values.maxConcurrent}
                          variant="outlined"
                          step={1}
                          min={1}
                          max={10}
                        />
                      </Grid>
                      <Grid
                        item
                        xs={12}
                      >
                        <Typography style={{
                          display: 'flex'
                        }} variant="body2" color="textSecondary" paragraph>
                          <div style={{
                            flexGrow : 1
                          }}/>
                          ({formik.values.duration}) Month(s)
                        </Typography>
                        <Slider
                          error={Boolean(formik.touched.duration && formik.errors.duration)}
                          fullWidth
                          helperText={formik.touched.duration && formik.errors.duration}
                          label="Duration"
                          name="duration"
                          onBlur={formik.handleBlur}
                          onChange={formik.handleChange}
                          value={formik.values.duration}
                          variant="outlined"
                          step={1}
                          min={1}
                          max={24}
                        />
                      </Grid>
                      <Grid
                        item
                        xs={12}
                      >
                        <TextField
                          error={Boolean(formik.touched.api_access && formik.errors.api_access)}
                          fullWidth
                          helperText={formik.touched.api_access && formik.errors.api_access}
                          label="API Access"
                          name="api_access"
                          onBlur={formik.handleBlur}
                          onChange={formik.handleChange}
                          select
                          value={formik.values.api_access}
                          variant="outlined"
                        >
                            <MenuItem
                              value={false}
                            >
                              No
                            </MenuItem>
                            <MenuItem
                              value={true}
                            >
                              Yes
                            </MenuItem>
                        </TextField>
                      </Grid>
                      <Grid
                        item
                        xs={12}
                      >
                        <TextField
                          error={Boolean(formik.touched.loop_access && formik.errors.loop_access)}
                          fullWidth
                          helperText={formik.touched.loop_access && formik.errors.loop_access}
                          label="Loop Feature"
                          name="loop_access"
                          onBlur={formik.handleBlur}
                          onChange={formik.handleChange}
                          select
                          value={formik.values.loop_access}
                          variant="outlined"
                        >
                            <MenuItem
                              value={false}
                            >
                              No
                            </MenuItem>
                            <MenuItem
                              value={true}
                            >
                              Yes
                            </MenuItem>
                        </TextField>
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
                          fullWidth
                          type="submit"
                          variant="contained"
                        >
                          Update
                        </Button>
                      </Grid>
                    </Grid>
                  </div>
                </form>
              </Card>
            </Grid>
          </Grid>
        </Container>
      </Box>
      </LoadingScreen>
    </>
  );
}
