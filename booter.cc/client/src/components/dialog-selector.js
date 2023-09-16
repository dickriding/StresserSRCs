import React, { useCallback, Fragment } from "react";
import PropTypes from "prop-types";
import RedeemDialog from "./redeem-dialog";
import PurchaseDialog from  "./purchase-dialog";
import ModalBackdrop from './modal-backdrop';

function DialogSelector(props) {
  const {
    dialogOpen,
    onClose,
  } = props;
  const _onClose = useCallback(() => {
    onClose();
  }, [onClose]);

  const printDialog = useCallback(() => {
    switch (dialogOpen) {
      case "redeem":
        return <RedeemDialog onClose={_onClose} />;
      case "purchase":
        return <PurchaseDialog onClose={_onClose} />;
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

DialogSelector.propTypes = {
  dialogOpen: PropTypes.string,
  onClose: PropTypes.func.isRequired
};

export default DialogSelector;