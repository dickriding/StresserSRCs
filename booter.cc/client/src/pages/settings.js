import { useState, useEffect } from 'react';
import { Helmet } from 'react-helmet';
import { useFormik } from 'formik';
import * as Yup from 'yup';
import {
  Avatar,
  Box,
  Button,
  Card,
  Container,
  FormHelperText,
  Grid,
  TextField,
  Typography
} from '@material-ui/core';
import Axios from '../handler/axios';
import LoadingScreen from 'react-loading-screen';
import authenticate from '../handler/authenticate';
import { ToastContainer, toast } from 'react-toastify';
import { getTime } from 'date-fns';

export const Settings = () => {
  const [loading, setLoading] = useState(true)
  const [info, setInfo] = useState({
    username : '',
    email : ''
  })
  useEffect( () => {
    async function fetchData() {
      const authRequest = await authenticate()
      if(!authRequest)
        window.location.href = '/login'
      else {
        const token = getTime(new Date())
        const request = await Axios.get(`/settings/getData/${token}`)
        if(request.data.success) {
          setInfo(request.data.message)
          setLoading(false)
        }
      }
    }
    fetchData();
  }, [])
  const formik = useFormik({
    initialValues: {
      password: '',
      newpassword: '',
      repeatnewpassword: ''
    },
    validationSchema: Yup.object().shape({
      password: Yup.string().max(255).required('Password is required'),
      newpassword: Yup.string().max(255).required('New Password is required'),
      repeatnewpassword: Yup.string().max(255).required('Repeat New Password is required'),
    }),
    onSubmit: async (values, helpers) => {
      try {
        const token = getTime(new Date())
        const request = await Axios.post(`/settings/changePassword/${token}`, 
          values
        )
        if(request.data.success) {
          helpers.setStatus({ success: true });
          helpers.setSubmitting(false);
          toast.success(`Password has been changed.`, {
            position : "top-right",
            autoClose: 5000,
            hideProgressBar: false,
            closeOnClick: true,
            draggable: true,
            progress: undefined,
          })
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

  return (
    <>
      <Helmet>
        <title>Settings | BOOTER.CC</title>
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
            Settings
          </Typography>
          <Card
            variant="outlined"
            sx={{ p: 3 }}
          >
            <Grid
              container
              spacing={3}
            >
              <Grid
                item
                md={4}
                xs={12}
              >
                <Typography
                  color="textPrimary"
                  variant="h6"
                >
                  Account
                </Typography>
              </Grid>
              <Grid
                item
                md={8}
                xs={12}
              >
                <form onSubmit={formik.handleSubmit}>
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
                        <Button
                          color="primary"
                          size="small"
                          sx={{ mb: 1 }}
                          disabled
                          type="button"
                          variant="outlined"
                        >
                          Upload new picture
                        </Button>
                        <div>
                          <Typography
                            color="textSecondary"
                            variant="caption"
                          >
                            Recommended dimensions: 200x200, maximum file size: 5MB
                          </Typography>
                        </div>
                      </div>
                    </Box>
                    <Grid
                      container
                      spacing={2}
                      sx={{ maxWidth: 420 }}
                    >
                      <Grid
                        item
                        xs={12}
                      >
                        <TextField
                          fullWidth
                          label="Username"
                          name="username"
                          disabled
                          value={info.username}
                          variant="outlined"
                        />
                      </Grid>
                      <Grid
                        item
                        xs={12}
                      >
                        <TextField
                          fullWidth
                          label="Email address"
                          name="email"
                          disabled
                          type="email"
                          value={info.email}
                          variant="outlined"
                        />
                      </Grid>
                      <Grid
                        item
                        xs={12}
                      >
                        <TextField
                          error={Boolean(formik.touched.password && formik.errors.password)}
                          fullWidth
                          helperText={formik.touched.password && formik.errors.password}
                          label="Current password"
                          name="password"
                          type="password"
                          onBlur={formik.handleBlur}
                          onChange={formik.handleChange}
                          value={formik.values.password}
                          variant="outlined"
                        />
                      </Grid>
                      <Grid
                        item
                        xs={12}
                      >
                        <TextField
                          error={Boolean(formik.touched.newpassword && formik.errors.newpassword)}
                          fullWidth
                          helperText={formik.touched.newpassword && formik.errors.newpassword}
                          label="New Password"
                          name="newpassword"
                          type="password"
                          onBlur={formik.handleBlur}
                          onChange={formik.handleChange}
                          value={formik.values.newpassword}
                          variant="outlined"
                        />
                      </Grid>
                      <Grid
                        item
                        xs={12}
                      >
                        <TextField
                          error={Boolean(formik.touched.repeatnewpassword && formik.errors.repeatnewpassword)}
                          fullWidth
                          helperText={formik.touched.repeatnewpassword && formik.errors.repeatnewpassword}
                          label="Confirm New Password"
                          name="repeatnewpassword"
                          type="password"
                          onBlur={formik.handleBlur}
                          onChange={formik.handleChange}
                          value={formik.values.repeatnewpassword}
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
                          Save settings
                        </Button>
                      </Grid>
                    </Grid>
                  </div>
                </form>
              </Grid>
            </Grid>
          </Card>
        </Container>
      </Box>
      <ToastContainer />
      </LoadingScreen>
    </>
  );
};