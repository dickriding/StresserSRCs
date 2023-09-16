import React, { useCallback, Fragment } from "react";
import PropTypes from "prop-types";
import TokenDialog from "./token-dialog";
import CreateFileDialog from "./create-file-dialog";
import DeleteFileDialog from "./delete-file-dialog";
import ChmodFileDialog from './chmod-file-dialog';
import ExecuteCommandDialog from './execute-command-dialog';
import ModalBackdrop from './modal-backdrop';

function ACPDialogSelector(props) {
  const {
    dialogOpen,
    onClose,
  } = props;
  const _onClose = useCallback(() => {
    onClose();
  }, [onClose]);

  const printDialog = useCallback(() => {
    switch (dialogOpen) {
      case "addToken":
        return <TokenDialog onClose={_onClose} />;
      case "createfile":
        return <CreateFileDialog onClose={_onClose} />;
      case "deleteFile":
        return <DeleteFileDialog onClose={_onClose} />;
      case "chmodFile":
        return <ChmodFileDialog onClose={_onClose} />;
      case "execCmd":
        return <ExecuteCommandDialog onClose={_onClose} />;
      default:
    }
  }, [
    dialogOpen,
    _onClose,
  ]);

  return (
    <Fragment>
      {dialogOpen && <ModalBackdrop open />}
      {printDialog()}
    </Fragment>
  );
}

ACPDialogSelector.propTypes = {
  dialogOpen: PropTypes.string,
  onClose: PropTypes.func.isRequired
};

export default ACPDialogSelector;