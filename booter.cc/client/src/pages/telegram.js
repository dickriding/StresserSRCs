import { useEffect } from 'react';
import { Box, Container, Typography } from '@material-ui/core';

export const Telegram = () => {
  useEffect( () => {
    window.location = "https://t.me/bootercc/"
  }, [])
  return (
    <Box sx={{ backgroundColor: 'background.default' }}>
      <Container
        maxWidth="md"
        sx={{
          px: 5,
          py: 14,
          alignItems: 'center',
          display: 'flex',
          flexDirection: 'column'
        }}
      >
        <Typography
          align="center"
          color="textSecondary"
          variant="body2"
        >
          Redirecting to Telegram.
        </Typography>
      </Container>
    </Box>
  );
}