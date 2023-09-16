import React, { useCallback, Fragment } from "react";
import PropTypes from "prop-types";
import AttackDialog from "./attack-dialog";
import LoopDialog from "./loop-dialog";
import ModalBackdrop from './modal-backdrop';

function DialogSelector2(props) {
  const {
    dialogOpen,
    onClose,
    data,
    getBoots
  } = props;
  const _onClose = useCallback(() => {
    onClose();
  }, [onClose]);

  const printDialog = useCallback(() => {
    switch (dialogOpen) {
      case "atk":
        return <AttackDialog data={data} getBoots={getBoots} onClose={_onClose} />;
      case "loop":
        return <LoopDialog data={data} getBoots={getBoots} onClose={_onClose} />;
      default:
    }
  }, [
    dialogOpen,
    _onClose,
    getBoots,
    data
  ]);

  return (
    <Fragment>
      {dialogOpen && <ModalBackdrop open />}
      {printDialog()}
    </Fragment>
  );
}

DialogSelector2.propTypes = {
  dialogOpen: PropTypes.string,
  onClose: PropTypes.func.isRequired,
  getBoots: PropTypes.func.isRequired
};

export default DialogSelector2;