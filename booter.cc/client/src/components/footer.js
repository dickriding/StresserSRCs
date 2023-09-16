import { Box, Container, Link, Typography } from '@material-ui/core';

export const Footer = () => (
  <Box component="footer">
    <Container maxWidth="lg">
      <Box
        sx={{
          display: 'flex',
          flexDirection: {
            md: 'row',
            xs: 'column'
          },
          marginBottom: 6,
          p: 3,
          '& a': {
            mt: {
              md: 0,
              xs: 2
            }
          }
        }}
      >
        <Typography
          color="textSecondary"
          variant="body2"
        >
          © 2021 BOOTER.CC
        </Typography>
        <Box sx={{ flexGrow: 1 }} />
        <Link
          color="textSecondary"
          href="https://booter.cc/tos"
          sx={{ px: 1 }}
          target="_blank"
          variant="body2"
        >
          Terms of Service
        </Link>
        <Link
          color="textSecondary"
          href="https://booter.cc/about"
          sx={{ px: 1 }}
          target="_blank"
          underline="hover"
          variant="body2"
        >
          About Us
        </Link>
      </Box>
    </Container>
  </Box>
);
