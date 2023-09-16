import PropTypes from 'prop-types';
import {
  Box,
  Button
} from '@material-ui/core';
import { Adjustments as AdjustmentsIcon } from '../../icons/adjustments';
import { Query } from '../query';

export const UsersFilter = (props) => {
  const { onQueryChange, query } = props;

  return (
    <Box
      sx={{
        alignItems: 'center',
        display: 'grid',
        gap: 2,
        gridTemplateColumns: {
          sm: '1fr auto',
          xs: 'auto'
        },
        justifyItems: 'flex-start',
        p: 3
      }}
    >
      <Query
        onChange={onQueryChange}
        sx={{
          order: {
            sm: 2,
            xs: 1
          }
        }}
        value={query}
      />
      <Box
        sx={{
          alignItems: 'center',
          display: 'flex',
          order: 3
        }}
      >
        <Button
          color="primary"
          startIcon={<AdjustmentsIcon />}
          size="large"
          sx={{ order: 3 }}
          onClick={() => onQueryChange(query)}
        >
          Filter
        </Button>
      </Box>
    </Box>
  );
};

UsersFilter.propTypes = {
  onQueryChange: PropTypes.func,
  query: PropTypes.string
};
