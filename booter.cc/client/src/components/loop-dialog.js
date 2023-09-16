import React, { useState } from "react";
import PropTypes from "prop-types";
import {
  Dialog,
  DialogContent,
  Typography,
  Grid,
  TextField,
  FormHelperText,
  MenuItem,
  Button
} from "@material-ui/core";
import { useFormik } from 'formik';
import * as Yup from 'yup';
import Axios from '../handler/axios';
import DialogTitleWithCloseIcon from "./dialog-title-with-close-icon";
import { ToastContainer, toast } from 'react-toastify';
import { getTime } from 'date-fns';

function LoopDialog(props) {
  const { onClose, data, getBoots } = props;
  const formik = useFormik({
    initialValues: {
      host : '',
      mode: '',
      restOption: '',
      cookie : '',
      proxy: 0
    },
    validationSchema: Yup.object().shape({
      proxy : Yup.number().default(0),
      mode: Yup.string().required('Please pick a mode.'),
      host : Yup.string().min(1).max(255).url('Must be a URL').required('Target host is required'),
      cookie: Yup.string().matches(/^\S+$/, 'Cookie example: cookie1=value1;cookie2=value2'),
      postdata : Yup.string().matches(/^\S+$/, 'Post-data example: user=value1;password=value2 (rand for randomized string)'),
      restOption : Yup.string()
    }),
    onSubmit: async (values, helpers) => {
      try {
        console.log(values)
        const token = getTime(new Date())
        const request = await Axios.post(`/panel/loop/${token}`, 
          values
        )
        if(request.data.success) {
          helpers.setStatus({ success: true });
          helpers.setSubmitting(false);
          toast.success(`Loop attack was sent successfuly.`, {
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
  return (
    <>
    <Dialog open scroll="paper" onClose={onClose} hideBackdrop>
      <DialogTitleWithCloseIcon
        title={"Loop Panel"}
        onClose={onClose}
        disabled={false}
      />
      <DialogContent>
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
                <Typography variant="h6" color="primary" paragraph>
                  Do not abuse.
                </Typography>
                </Grid>
                <Grid
                  item
                  xs={12}
                >
                  <TextField
                    error={Boolean(formik.touched.mode && formik.errors.mode)}
                    fullWidth
                    helperText={formik.touched.mode && formik.errors.mode}
                    label="Mode"
                    name="mode"
                    onBlur={formik.handleBlur}
                    onChange={formik.handleChange}
                    select
                    value={formik.values.mode}
                    variant="outlined"
                  >
                    {['Regular', 'Advanced'].map((c) => (
                      <MenuItem
                        key={c}
                        value={c.toLowerCase()}
                      >
                        {c}
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
                  label="A HTTP/HTTPS address"
                  name="host"
                  onBlur={formik.handleBlur}
                  disabled={formik.values.mode ? false : true}
                  onChange={formik.handleChange}
                  value={formik.values.host}
                  variant="outlined"
                />
              </Grid> 
              {
                formik.values.mode === 'advanced' && (
                  <>
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
                        disabled={formik.values.mode ? false : true}
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
                        disabled={formik.values.mode ? false : true}
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
                    {
                      formik.values.restOption === 'post' && (
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
                            disabled={formik.values.mode ? false : true}
                            value={formik.values.postdata}
                            variant="outlined"
                          />
                        </Grid>
                      )
                    }
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
                        disabled={formik.values.mode ? false : true}
                        value={formik.values.cookie}
                        variant="outlined"
                      />
                    </Grid>
                  </>
                )
              }    
              <Grid
                item
                xs={12}
              >
                <Button
                  color="primary"
                  size="large"
                  type="submit"
                  disabled={formik.values.mode ? false : true}
                  variant="contained"
                >
                  Loop through
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

LoopDialog.propTypes = {
  onClose: PropTypes.func.isRequired,
  getBoots: PropTypes.func.isRequired
};

export default LoopDialog;
