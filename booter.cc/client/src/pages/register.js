import React, { useState, useEffect } from 'react';
import {
  Button,
  TextField,
  Link,
  Grid,
  Typography,
  Card,
  Container,
  FormHelperText
} from '@material-ui/core'
import { useFormik } from 'formik';
import Axios from '../handler/axios';
import * as Yup from 'yup';
import LoadingScreen from 'react-loading-screen';
import authenticate from '../handler/authenticate';
import Recaptcha from "react-google-recaptcha"

export const Register = () => {
  const [loading, setLoading] = useState(true)
  useEffect( () => {
    async function fetchData() {
      const authRequest = await authenticate()
      if(authRequest)
        window.location.href = '/dashboard'
      else {
        const script = document.createElement("script");
        script.src =
          "https://www.google.com/recaptcha/api.js";
        script.async = true;
        script.defer = true;
        document.body.appendChild(script);
        setLoading(false)
      }
    }
    fetchData();
  }, [])
  const formik = useFormik({
    initialValues: {
      username: '',
      email : '',
      password: '',
      recaptcha : ''
    },
    validationSchema: Yup.object().shape({
      username: Yup.string().max(255).required('Username is required'),
      email : Yup.string().max(255).email().required('Email is required.'),
      password: Yup.string().max(255).required('Password is required.'),
      recaptcha: Yup.string().required('reCaptcha is requried.')
    }),
    onSubmit: async (values, helpers) => {
      try {
        const request = await Axios.post(`/register`, 
          values
        )
        if(request.data.success) {
          window.location.href = "/login";
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
    <Container component="main" maxWidth="xs">
    <LoadingScreen
      loading={loading}
      bgColor='#111318'
      spinnerColor='#ECEDED'
    > 
      <Card
        sx={{
          display: 'grid',
          mt: 5,
          gap: 3,
          gridAutoFlow: 'row',
          p: 3
        }}
        variant="outlined"
      >
        <div
        style={{
          display: 'flex',
          flexDirection: 'column',
          alignItems: 'center',
        }}
        >
          <Typography 
            sx={{
              mt: 1,
              mb: 3
            }}
            component="h1" 
            variant="h5"
          >
            Sign Up
          </Typography>
          <form 
            sx={{
              width: '100%', // Fix IE 11 issue.
            }} 
            style={{
              marginTop : '1rem'
            }}
            onSubmit={formik.handleSubmit}
            noValidate
          >
            <Grid container spacing={2}>
              <Grid item xs={12}>
                <TextField
                  error={Boolean(formik.touched.username && formik.errors.username)}
                  fullWidth
                  helperText={formik.touched.username && formik.errors.username}
                  label="Username"
                  name="username"
                  onBlur={formik.handleBlur}
                  onChange={formik.handleChange}
                  value={formik.values.username}
                  variant="outlined"  
                  sx={{
                    mb : 3
                  }}
                />
              </Grid>
              <Grid item xs={12}>
                <TextField
                  error={Boolean(formik.touched.email && formik.errors.email)}
                  fullWidth
                  helperText={formik.touched.email && formik.errors.email}
                  label="Email"
                  name="email"
                  onBlur={formik.handleBlur}
                  onChange={formik.handleChange}
                  value={formik.values.email}
                  variant="outlined"  
                  sx={{
                    mb : 3
                  }}
                />
              </Grid>
              <Grid item xs={12}>
                <TextField
                  error={Boolean(formik.touched.password && formik.errors.password)}
                  fullWidth
                  helperText={formik.touched.password && formik.errors.password}
                  label="Password"
                  name="password"
                  type="password"
                  onBlur={formik.handleBlur}
                  onChange={formik.handleChange}
                  value={formik.values.password}
                  variant="outlined"
                />
              </Grid>
              <Grid item xs={12}>
                <Recaptcha
                  sitekey="6Lc0ulgbAAAAAMtwY5sqCHw-PlVrozCmNc_yOaMz"
                  theme="dark"
                  size="normal"
                  onChange={(value) => {
                    formik.setFieldValue("recaptcha", value);
                    formik.setSubmitting(false);
                  }}
                />
                {formik.errors.recaptcha 
                  && formik.touched.recaptcha && (
                  <FormHelperText error>{formik.errors.recaptcha}</FormHelperText>
                )}
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
            </Grid>
            <Button
              type="submit"
              fullWidth
              variant="contained"
              color="primary"
              sx={{
                mt: 2,
                mb: 2
              }}
            >
              Sign Up
            </Button>
            <Grid container justifyContent="flex-end">
              <Grid item>
                <Link href="/login" variant="body2">
                  Already have an account? Sign in
                </Link>
              </Grid>
            </Grid>
          </form>
        </div>
      </Card>
    </LoadingScreen>
    </Container>
  );
}