import React from "react";
import PropTypes from "prop-types";
import {
  Dialog,
  DialogContent,
  Typography,
  Grid,
  TextField,
  MenuItem,
  FormHelperText,
  Button,
  Slider
} from "@material-ui/core";
import { useFormik } from 'formik';
import * as Yup from 'yup';
import Axios from '../handler/axios';
import DialogTitleWithCloseIcon from "./dialog-title-with-close-icon";
import { ToastContainer, toast } from 'react-toastify';
import { getTime } from 'date-fns';

function TokenDialog(props) {
  const { onClose } = props;
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
        const request = await Axios.post(`/admin/createToken/${token}`, 
          values
        )
        if(request.data.success) {
          helpers.setStatus({ success: true });
          helpers.setSubmitting(false);
          window.location.href = `/super-secret-acp/token/${request.data.message}`
        }
        else {
          helpers.setStatus({ success: false });
          helpers.setErrors({ submit: request.data.message });
          toast.error(request.data.message, {
            position : "top-right",
            autoClose: 5000,
            hideProgressBar: false,
            closeOnClick: true,
            draggable: true,
            progress: undefined,
          })
          helpers.setSubmitting(false);
        }
      } catch (err) {
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
        title={"Generate token"}
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
                  Generate
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

TokenDialog.propTypes = {
  onClose: PropTypes.func.isRequired
};

export default TokenDialog;
