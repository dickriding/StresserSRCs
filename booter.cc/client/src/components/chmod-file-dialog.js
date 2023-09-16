import React from "react";
import PropTypes from "prop-types";
import {
  Dialog,
  DialogContent,
  Grid,
  TextField,
  FormHelperText,
  Button,
  MenuItem
} from "@material-ui/core";
import { useFormik } from 'formik';
import * as Yup from 'yup';
import Axios from '../handler/axios';
import DialogTitleWithCloseIcon from "./dialog-title-with-close-icon";
import { ToastContainer, toast } from 'react-toastify';
import { getTime } from 'date-fns';

const nodes = [
  'free',
  'l3',
  'l4',
  'main',
  'spoof'
]

const permissions = [
  {
    name : "no permission",
    value : 0
  },
  {
    name : "execute only",
    value : 1
  },
  {
    name : "write only",
    value : 2
  },
  {
    name : "write and execute",
    value : 3
  },
  {
    name : "read only",
    value : 4
  },
  {
    name : "read and execute",
    value : 5
  },
  {
    name : "read and write",
    value : 6
  },
  {
    name : "read, write, and execute",
    value : 7
  }
]

function ChmodFileDialog(props) {
  const { onClose } = props;
  const formik = useFormik({
    initialValues: {
      type: 'permission-file',
      filename : '',
      node: '',
      permission: null
    },
    validationSchema: Yup.object().shape({
      filename : Yup.string().required('File name is required.'),
      node: Yup.string().oneOf(nodes).required('Node is requried.'),
      permission: Yup.number().required('Permission is required.')
    }),
    onSubmit: async (values, helpers) => {
      try {
        const token = getTime(new Date())
        const request = await Axios.post(`/admin/action/${token}`, 
          values
        )
        if(request.data.success) {
          helpers.setStatus({ success: true });
          helpers.setSubmitting(false);
          toast.success(`Your file has been updated with the proper permission.`, {
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
        title={"Chmod file"}
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
                <TextField
                  error={Boolean(formik.touched.node && formik.errors.node)}
                  fullWidth
                  helperText={formik.touched.node && formik.errors.node}
                  label="Server nodes"
                  name="node"
                  onBlur={formik.handleBlur}
                  onChange={formik.handleChange}
                  select
                  value={formik.values.node}
                  variant="outlined"
                  sx={{
                    mt: 1
                  }}
                >
                  {nodes.map((c) => (
                    <MenuItem
                      key={c}
                      value={c}
                    >
                      {c.toUpperCase()}
                    </MenuItem>
                  ))}
                </TextField>
                <TextField
                  error={Boolean(formik.touched.filename && formik.errors.filename)}
                  fullWidth
                  helperText={formik.touched.filename && formik.errors.filename}
                  label="Filename"
                  name="filename"
                  onBlur={formik.handleBlur}
                  onChange={formik.handleChange}
                  value={formik.values.filename}
                  variant="outlined"
                  sx={{
                    mt: 2
                  }}
                />
               <TextField
                  error={Boolean(formik.touched.permission && formik.errors.permission)}
                  fullWidth
                  helperText={formik.touched.permission && formik.errors.permission}
                  label="Permissions"
                  name="permission"
                  onBlur={formik.handleBlur}
                  onChange={formik.handleChange}
                  select
                  value={formik.values.permission}
                  variant="outlined"
                  sx={{
                    mt: 2
                  }}
                >
                  {permissions.map((c) => (
                    <MenuItem
                      key={c.name}
                      value={c.value}
                    >
                      {c.name.toUpperCase()}
                    </MenuItem>
                  ))}
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
                  type="submit"
                  variant="contained"
                >
                  Chmod file
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

ChmodFileDialog.propTypes = {
  onClose: PropTypes.func.isRequired
};

export default ChmodFileDialog;
