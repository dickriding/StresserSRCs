import { useEffect, useState } from 'react';
import { Helmet } from 'react-helmet';
import { Box, Container, Grid, Typography } from '@material-ui/core';
import { SummaryItem } from '../components/reports/summary-item';
import { PerformanceIndicators } from '../components/reports/performance-indicators';
import { Boots as BootsIcon } from '../icons/boots';
import { Users as UsersIcon } from '../icons/users';
import { Gun as GunIcon } from '../icons/gun';
import Axios from '../handler/axios';
import LoadingScreen from 'react-loading-screen';
import authenticate from '../handler/authenticate';
import { getTime } from 'date-fns';

export const Dashboard = () => {
  const [loading, setLoading] = useState(true)
  useEffect( () => {
    async function fetchData() {
      const authRequest = await authenticate()
      if(!authRequest)
        window.location.href = '/login'
      else
        setLoading(false)
    }
    fetchData();
  }, [])
  const [stats, changeStats] = useState([
    {
      content: '0',
      icon: UsersIcon,
      label: 'Users'
    },
    {
      content: '0',
      icon: BootsIcon,
      label: 'Boots'
    },
    {
      content: '0',
      icon: GunIcon,
      label: 'Ongoing'
    }
  ]);
  const loadStats = async () => {
    const token = getTime(new Date())
    const request = await Axios.get(`/information/${token}`)
    if(request.data.success)
      changeStats([
        {
          content: request.data.message.totalUsers,
          icon: UsersIcon,
          label: 'Users'
        },
        {
          content: request.data.message.totalBoots,
          icon: BootsIcon,
          label: 'Boots'
        },
        {
          content: request.data.message.totalServers,
          icon: GunIcon,
          label: 'Ongoing'
        }
      ])
  }
  useEffect( () => {
    loadStats()
  }, [])
  return (
    <>
      <Helmet>
        <title>Dashboard | BOOTER.CC</title>
      </Helmet>
      <LoadingScreen
        loading={loading}
        bgColor='#111318'
        spinnerColor='#ECEDED'
      > 
      <Box
        sx={{
          backgroundColor: 'background.default',
          pb: 3,
          pt: 8
        }}
      >
        <Container maxWidth="lg">
          <Grid
            container
            spacing={3}
          >
            <Grid
              item
              xs={12}
            >
              <Typography
                color="textPrimary"
                variant="h4"
              >
                Attack hub
              </Typography>
            </Grid>
            {stats.map((item) => (
              <Grid
                item
                key={item.label}
                md={4}
                xs={12}
              >
                <SummaryItem
                  content={item.content}
                  icon={item.icon}
                  label={item.label}
                />
              </Grid>
            ))}
            <Grid
              item
              xs={12}
            >
              <PerformanceIndicators />
            </Grid>
          </Grid>
        </Container>
      </Box>
      </LoadingScreen>
    </>
  );
}