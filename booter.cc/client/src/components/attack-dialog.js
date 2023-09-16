import React, { useState } from "react";
import PropTypes from "prop-types";
import {
  Dialog,
  DialogContent,
  Typography,
  Grid,
  TextField,
  FormHelperText,
  Button,
  MenuItem,
  Slider,
  InputAdornment
} from "@material-ui/core";
import { useFormik } from 'formik';
import * as Yup from 'yup';
import Axios from '../handler/axios';
import DialogTitleWithCloseIcon from "./dialog-title-with-close-icon";
import { ToastContainer, toast } from 'react-toastify';
import { getTime } from 'date-fns';

const allMethodTypes = [
  {
    name: 'Layer 3',
    value: 3
  },
  {
    name: 'Layer 4',
    value: 4
  },
  {
    name: 'Layer 7',
    value: 7
  },
  {
    name: 'Advanced L7',
    value: 70
  },
]
function PurchaseDialog(props) {
  const { onClose, data, getBoots } = props;
  const [selectedMethod, setMethodIndex] = useState(null);
  const [currMethods, setcurrMethods] = useState([])
  const [delay, setIsDelay] = useState(false);

  const formik = useFormik({
    initialValues: {
      host : '',
      port : undefined,
      time : 30,
      method : '',
      proxy : 0,
      postdata : '',
      headers : '',
      submit: null,
      restOption: '',
      cookie : '',
      getquery : ''
    },
    validationSchema: Yup.object().shape({
      host : Yup.string().min(1).max(255).required('Target host is required'),
      port : Yup.number().min(1).max(65535).positive(),
      time : Yup.number().positive().min(30).max(data.maxTime).required('Target time is required'),
      method : Yup.string().required('Target method is required'),
      proxy : Yup.number().default(0),
      restOption : Yup.string(),
      postdata : Yup.string().matches(/^\S+$/, 'Post-data example: user=value1;password=value2 (rand for randomized string)'),
      headers : Yup.string(),
      getquery : Yup.string(),
      cookie: Yup.string().matches(/^\S+$/, 'Cookie example: cookie1=value1;cookie2=value2')
    }),
    onSubmit: async (values, helpers) => {
      try {
        console.log(values)
        const token = getTime(new Date())
        const request = await Axios.post(`/panel/launch/${token}`, 
          values
        )
        if(request.data.success) {
          helpers.setStatus({ success: true });
          helpers.setSubmitting(false);
          toast.success(`Stress test was successful.`, {
            position : "top-right",
            autoClose: 5000,
            hideProgressBar: false,
            closeOnClick: true,
            draggable: true,
            progress: undefined,
          })
          getBoots()
        }
        else {
          helpers.setStatus({ success: false });
          toast.error(request.data.message, {
            position : "top-right",
            autoClose: 5000,
            hideProgressBar: false,
            closeOnClick: true,
            draggable: true,
            progress: undefined,
          })
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
  const getMIndex = (event) => {
    setMethodIndex(currMethods.filter((item) => { return item.id === event.target.value })[0])
  }
  const filterMethods = (event) => {
    const currSelMethods = data.availableMethods.filter((item) => {
      return item.layer === event.target.value         
    })
    setcurrMethods(currSelMethods)
    setMethodIndex(null)
  }

  const handleSubmit = (event) => {
    setIsDelay(true)
    formik.handleSubmit(event)
    setTimeout(() => {
        setIsDelay(false)
    }, 1500)
  }
  return (
    <>
    <Dialog open scroll="paper" onClose={onClose} hideBackdrop>
      <DialogTitleWithCloseIcon
        title={"Attack Panel"}
        onClose={onClose}
        disabled={false}
      />
      <DialogContent>
        <form onSubmit={(e) => handleSubmit(e)}>
          <div>
            <Grid
              container
              spacing={2}
            >
              <Grid
                item
                xs={12}
              >
                <Typography variant="h6" color="primary" paragraph>
                  Comply with our terms of service.
                </Typography>
              </Grid>
              <Grid
                item
                xs={12}
              >
                <TextField
                  fullWidth
                  label="Layers"
                  name="restOption"
                  onChange={filterMethods}
                  select
                  variant="outlined"
                >
                  {allMethodTypes.map((c) => (
                    <MenuItem
                      key={c.value}
                      value={c.value}
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
                  error={Boolean(formik.touched.method && formik.errors.method)}
                  fullWidth
                  helperText={formik.touched.method && formik.errors.method}
                  label="Methods"
                  name="method"
                  onBlur={formik.handleBlur}
                  onChange={ (event) => {
                    formik.handleChange(event)
                    getMIndex(event)
                  } }
                  select
                  disabled={currMethods.length > 0 ? false : true}
                  value={formik.values.method}
                  variant="outlined"
                >
                  {currMethods.map((c) => (
                    <MenuItem
                      key={c.id}
                      value={c.id}
                    >
                      {c.name}
                    </MenuItem>
                  ))}
                </TextField>
              </Grid>
              {
                selectedMethod && (selectedMethod.layer === 70 || selectedMethod.layer === 7) ? (
                  <Grid
                    item
                    xs={12}
                  >
                    <TextField
                      error={Boolean(formik.touched.proxy && formik.errors.proxy)}
                      fullWidth
                      helperText={formik.touched.proxy && formik.errors.proxy}
                      label="Proxy"
                      name="proxy"
                      onBlur={formik.handleBlur}
                      onChange={formik.handleChange}
                      select
                      value={formik.values.proxy}
                      disabled={selectedMethod ? false : true}
                      variant="outlined"
                    >
                      {data.proxiesList.map((c) => (
                        <MenuItem
                          key={c.code}
                          value={c.code}
                        >
                          {c.name}
                        </MenuItem>
                      ))}
                    </TextField>
                  </Grid>
                ) : ''
              }
              {
                selectedMethod && selectedMethod.option ? (
                  <Grid
                    item
                    xs={12}
                  >
                    <TextField
                      error={Boolean(formik.touched.restOption && formik.errors.restOption)}
                      fullWidth
                      helperText={formik.touched.restOption && formik.errors.restOption}
                      label="REST Option"
                      name="restOption"
                      onBlur={formik.handleBlur}
                      onChange={formik.handleChange}
                      select
                      disabled={selectedMethod ? false : true}
                      value={formik.values.restOption}
                      variant="outlined"
                    >
                      {['get', 'post', 'head'].map((c) => (
                        <MenuItem
                          key={c}
                          value={c}
                        >
                          {c.toUpperCase()}
                        </MenuItem>
                      ))}
                    </TextField>
                  </Grid>
                ) : ''
              }
              {
                selectedMethod && selectedMethod.http ? (
                  <Grid
                    item
                    xs={12}
                  >
                    <TextField
                      error={Boolean(formik.touched.host && formik.errors.host)}
                      fullWidth
                      helperText={formik.touched.host && formik.errors.host}
                      label="A HTTP/HTTPS URL"
                      name="host"
                      onBlur={formik.handleBlur}
                      onChange={formik.handleChange}
                      disabled={selectedMethod ? false : true}
                      value={formik.values.host}
                      variant="outlined"
                    />
                  </Grid>
                ) : (
                  <>
                    <Grid
                      item
                      xs={8}
                    >
                      <TextField
                        error={Boolean(formik.touched.host && formik.errors.host)}
                        fullWidth
                        helperText={formik.touched.host && formik.errors.host}
                        label="A domain name/IPv4/IPv6"
                        name="host"
                        onBlur={formik.handleBlur}
                        onChange={formik.handleChange}
                        disabled={selectedMethod ? false : true}
                        value={formik.values.host}
                        variant="outlined"
                      />
                    </Grid>
                    <Grid
                      item
                      xs={4}
                    >
                      <TextField
                        error={Boolean(formik.touched.port && formik.errors.port)}
                        fullWidth
                        helperText={formik.touched.port && formik.errors.port}
                        label="Port"
                        type="number"
                        name="port"
                        onBlur={formik.handleBlur}
                        onChange={formik.handleChange}
                        disabled={selectedMethod ? false : true}
                        value={formik.values.port}
                        variant="outlined"
                      />
                    </Grid>
                  </>
                )
              }
              {
                selectedMethod && selectedMethod.postdata && formik.values.restOption === 'post' ? (
                  <Grid
                    item 
                    xs={12}
                  >
                    <TextField
                      error={Boolean(formik.touched.postdata && formik.errors.postdata)}
                      fullWidth
                      helperText={formik.touched.postdata && formik.errors.postdata}
                      label="POST data"
                      name="postdata"
                      onBlur={formik.handleBlur}
                      onChange={formik.handleChange}
                      disabled={selectedMethod ? false : true}
                      value={formik.values.postdata}
                      variant="outlined"
                    />
                  </Grid>
                ) : ''
              }              
              {
                selectedMethod && selectedMethod.getquery ? (
                  <Grid
                    item 
                    xs={12}
                  >
                    <TextField
                      error={Boolean(formik.touched.getquery && formik.errors.getquery)}
                      fullWidth
                      helperText={formik.touched.getquery && formik.errors.getquery}
                      label="GET query"
                      name="getquery"
                      onBlur={formik.handleBlur}
                      onChange={formik.handleChange}
                      disabled={selectedMethod ? false : true}
                      value={formik.values.getquery}
                      variant="outlined"
                      InputProps={{
                        startAdornment: <InputAdornment position="start">?</InputAdornment>,
                      }}
                    />
                  </Grid>
                ) : ''
              }
              {
                selectedMethod && selectedMethod.cookie ? (
                  <Grid
                    item 
                    xs={12}
                  >
                    <TextField
                      error={Boolean(formik.touched.cookie && formik.errors.cookie)}
                      fullWidth
                      helperText={formik.touched.cookie && formik.errors.cookie}
                      label="Cookies"
                      name="cookie"
                      onBlur={formik.handleBlur}
                      onChange={formik.handleChange}
                      disabled={selectedMethod ? false : true}
                      value={formik.values.cookie}
                      variant="outlined"
                    />
                  </Grid>
                ) : ''
              }
              {
                selectedMethod && selectedMethod.headers ? (
                  <Grid 
                    item 
                    xs={12}
                  >
                    <TextField
                      error={Boolean(formik.touched.headers && formik.errors.headers)}
                      fullWidth
                      helperText={formik.touched.headers && formik.errors.headers}
                      label="HTTP Headers"
                      name="headers"
                      multiline
                      rows={4}
                      onBlur={formik.handleBlur}
                      onChange={formik.handleChange}
                      disabled={selectedMethod ? false : true}
                      value={formik.values.headers}
                      variant="outlined"
                    />
                  </Grid>
                ) : ''
              }
              <Grid 
                item 
                xs={12}
              >
                <Slider
                  error={Boolean(formik.touched.time && formik.errors.time)}
                  fullWidth
                  helperText={formik.touched.time && formik.errors.time}
                  label="Time"
                  name="time"
                  onBlur={formik.handleBlur}
                  onChange={formik.handleChange}
                  value={formik.values.time}
                  variant="outlined"
                  valueLabelDisplay="auto"
                  disabled={selectedMethod ? false : true}
                  step={1}
                  min={30}
                  max={data.maxTime}
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
                  disabled={!selectedMethod || delay}
                  variant="contained"
                >
                  Launch
                </Button>
              </Grid>
            </Grid>
          </div>
        </form>
      </DialogContent>
    </Dialog>
    <ToastContainer />
    </>
  );
}

PurchaseDialog.propTypes = {
  onClose: PropTypes.func.isRequired,
  getBoots: PropTypes.func.isRequired
};

export default PurchaseDialog;
