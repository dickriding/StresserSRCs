import React, { useState, useEffect } from 'react';
import {
  Button,
  Card,
  TextField,
  Link,
  Grid,
  Typography,
  FormHelperText,
  Container
} from '@material-ui/core'
import { useFormik } from 'formik';
import Axios from '../handler/axios';
import * as Yup from 'yup';
import LoadingScreen from 'react-loading-screen';
import authenticate from '../handler/authenticate';

export const Login = () => {
  const [loading, setLoading] = useState(true)
  useEffect( () => {
    async function fetchData() {
      const authRequest = await authenticate()
      if(authRequest)
        window.location.href = '/dashboard'
      else
        setLoading(false)
    }
    fetchData();
  }, [])
  const formik = useFormik({
    initialValues: {
      email : '',
      password: ''
    },
    validationSchema: Yup.object().shape({
      email : Yup.string().max(255).email().required('Email is required.'),
      password: Yup.string().max(255).required('Password is required.')
    }),
    onSubmit: async (values, helpers) => {
      try {
        const request = await Axios.post(`/login`, 
          values
        )
        if(request.data.success) {
          localStorage.setItem('authorizationToken', request.data.message);
          window.location.href = "/dashboard";
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
            Sign in
          </Typography>
          <form 
            sx={{
              width: '100%', // Fix IE 11 issue.
              mt: 1,
            }} 
            noValidate
            onSubmit={formik.handleSubmit}
          >
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
              Sign In
            </Button>
            <Grid container>
              <Grid item>
                <Link href="/register" variant="body2">
                  {"Don't have an account? Sign Up"}
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