import React from "react";
import PropTypes from "prop-types";
import {
  Dialog,
  DialogContent,
  Typography,
  Grid,
  TextField,
  FormHelperText,
  Button
} from "@material-ui/core";
import { useFormik } from 'formik';
import * as Yup from 'yup';
import Axios from '../handler/axios';
import DialogTitleWithCloseIcon from "./dialog-title-with-close-icon";
import { ToastContainer, toast } from 'react-toastify';
import { getTime } from 'date-fns';

function RedeemDialog(props) {
  const { onClose } = props;
  const formik = useFormik({
    initialValues: {
      tokenValue : ''
    },
    validationSchema: Yup.object().shape({
      tokenValue : Yup.string().length(12).required('Token is required.')
    }),
    onSubmit: async (values, helpers) => {
      try {
        const token = getTime(new Date())
        const request = await Axios.post(`/payhub/redeem/${token}`, 
          values
        )
        if(request.data.success) {
          helpers.setStatus({ success: true });
          helpers.setSubmitting(false);
          toast.success(`Your subscription has been updated.`, {
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
        title={"Redeem"}
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
                  Warning:
                </Typography>
                <Typography paragraph>
                  Redeeming a token will overwrite your current subscription plans, this 
                  action is irreversible and recovering your old subscription will be impossible.
                </Typography>
                <TextField
                  error={Boolean(formik.touched.tokenValue && formik.errors.tokenValue)}
                  fullWidth
                  helperText={formik.touched.tokenValue && formik.errors.tokenValue}
                  label="Token"
                  name="tokenValue"
                  onBlur={formik.handleBlur}
                  onChange={formik.handleChange}
                  value={formik.values.tokenValue}
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
                  Redeem
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

RedeemDialog.propTypes = {
  onClose: PropTypes.func.isRequired
};

export default RedeemDialog;
