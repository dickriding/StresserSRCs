import React from "react";
import PropTypes from "prop-types";
import {
  IconButton,
  DialogTitle,
  Typography,
  Box
} from "@material-ui/core";
import { Close as CloseIcon } from "../icons/close";

function DialogTitleWithCloseIcon(props) {
  const {
    onClose,
    disabled,
    title
  } = props;
  return (
    <DialogTitle
      style={{
        paddingBottom: "3rem",
        paddingTop: "2rem",
        width: "100%"
      }}
      disableTypography
    >
      <Box display="flex" justifyContent="space-between">
        <Typography variant="h5">{title}</Typography>
        <IconButton
          onClick={onClose}
          style={{ marginRight: -12, marginTop: -10 }}
          disabled={disabled}
          aria-label="Close"
        >
          <CloseIcon />
        </IconButton>
      </Box>
    </DialogTitle>
  );
}

DialogTitleWithCloseIcon.propTypes = {
  onClose: PropTypes.func,
  disabled: PropTypes.bool,
  title: PropTypes.string,
};

export default DialogTitleWithCloseIcon;
