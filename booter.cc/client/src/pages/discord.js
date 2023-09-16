import { useEffect } from 'react';
import { Box, Container, Typography } from '@material-ui/core';

export const Discord = () => {
  useEffect( () => {
    window.location = "https://discord.gg/5mtcFeQ9U8"
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
          Redirecting to Discord.
        </Typography>
      </Container>
    </Box>
  );
}