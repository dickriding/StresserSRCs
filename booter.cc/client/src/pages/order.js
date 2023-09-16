import { useEffect, useState } from 'react';
import { Helmet } from 'react-helmet';
import {
  useParams
} from "react-router-dom";
import { Box, Card, Container, Grid, Divider, Link, Typography } from '@material-ui/core';
import { format, getTime } from 'date-fns';
import Axios from '../handler/axios';
import axios from 'axios';
import { SummaryItem } from '../components/reports/summary-item';
import { Boots as BootsIcon } from '../icons/boots';
import { Time as TimeIcon } from '../icons/time';
import { Calender as CalenderIcon } from '../icons/calender';
import { Concurrent as ConcurrentIcon } from '../icons/concurrent';
import { APIYES as APIYESICON } from '../icons/api-yes';
import { APINO as APINOICON } from '../icons/api-no';
import LoadingScreen from 'react-loading-screen';
import authenticate from '../handler/authenticate';
import { CountdownCircleTimer } from 'react-countdown-circle-timer'

function convertHMS(value) {
  const sec = parseInt(value, 10); // convert value to number if it's string
  let hours   = Math.floor(sec / 3600); // get hours
  let minutes = Math.floor((sec - (hours * 3600)) / 60); // get minutes
  let seconds = sec - (hours * 3600) - (minutes * 60); //  get seconds
  // add 0 if value < 10; Example: 2 => 02
  if (hours   < 10) {hours   = "0"+hours;}
  if (minutes < 10) {minutes = "0"+minutes;}
  if (seconds < 10) {seconds = "0"+seconds;}
  return hours+':'+minutes+':'+seconds; // Return is HH : MM : SS
}

function calculatePayment(value) {
  var rex = 0
  for ( var i=0; i<value.length; i++ ) {
    rex += value.charCodeAt(i)
  }
  return rex
}

export const Order = () => {
  const [loading, setLoading] = useState(true)
  const [difference, setDifference] = useState(null)
  const [currentOrder, setOrder] = useState({
    'qrcode_url' : null,
    'start' : null,
    'duration' : null,
    'maxConcurrent' : null,
    'maxBoots' : null,
    'maxTime' : null,
    'api_access' : null,
    'key' : null,
    'address' : null,
    'received_confirms' : null,
    'received_amount' : null,
    'amount' : null,
    'status_text' : null,
    'timeout' : null
  })
  const [stats, changeStats] = useState([
    {
      content: '1 month(s)',
      icon: CalenderIcon,
      label: 'Duration'
    },
    {
      content: "360 second(s)",
      icon: TimeIcon,
      label: 'Time'
    },
    {
      content: 1,
      icon: ConcurrentIcon,
      label: 'Concurrent'
    },
    {
      content: 10,
      icon: BootsIcon,
      label: 'Boots'
    },
    {
      content: 'No',
      icon: APINOICON,
      label: 'API'
    }
  ]);
  const { id } = useParams();
  const checkOrder = async () => {
    const authRequest = await authenticate()
    if(!authRequest) {
      window.location.href = '/login'
    } else {
      const token = getTime(new Date())
      const request = await Axios.get(`/payhub/getOrder/${token}/${id}`)
      if(request.data.success) {
        setOrder(request.data.message)
        if(request.data.message.status === 0) {
          const today = new Date()
          let dt = new Date(request.data.message.start)
          dt.setMinutes( dt.getMinutes() + 480 )
          setDifference((dt - today) / 1000)
        }
        const currentDate = new Date()

        changeStats([
          {
            content: `${request.data.message.duration} month(s)`,
            icon: CalenderIcon,
            label: 'Duration'
          },
          {
            content: `${request.data.message.maxTime} second(s)`,
            icon: TimeIcon,
            label: 'Time'
          },
          {
            content: request.data.message.maxConcurrent,
            icon: ConcurrentIcon,
            label: 'Concurrent'
          },
          {
            content: 'Unlimited',
            icon: BootsIcon,
            label: 'Boots'
          },
          {
            content: request.data.message.api_access ? 'Yes' : 'No',
            icon: request.data.message.api_access ? APIYESICON : APINOICON,
            label: 'API'
          }
        ])
        setLoading(false)
      } else {
        window.location.href = '/404'
      }
    } 
  }
  useEffect( () => {
    checkOrder()
  }, [])
  return(
    <>
      <Helmet>
        <title>{`Order ${id}`} | BOOTER.CC</title>
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
          <Typography
            color="textPrimary"
            sx={{ mb: 3 }}
            variant="h4"
          >
            {`Order ${id}`}
          </Typography>
          <Grid
            container
          >
            <Grid
              item
              md={8}
              xs={12}
            >
              <Card
                sx={{
                  display: 'grid',
                  gap: 3,
                  gridAutoFlow: 'row',
                  p: 3
                }}
                variant="outlined"
              >
                <Grid 
                  container 
                  space={2}
                >
                  <Grid
                    item
                    sm={4}
                  > 
                    <Link
                      color="primary"
                      href={`bitcoin:${currentOrder.address}?amount=${currentOrder.amount}%26label=Candy`}
                      target="_blank"
                      variant="inherit"
                    >
                      <img style={{
                        width: '90%',
                      }} alt="qrcode" src={currentOrder.qrcode_url} />
                    </Link>
                    <Typography
                      color="textSecondary"
                      variant="body2"
                      sx={{
                        marginLeft: '1rem'
                      }}
                    >
                      Tap to scan or pay.
                    </Typography>
                  </Grid>
                  <Grid
                    item
                    sm={4}
                  > 
                    <Typography
                      color="textPrimary"
                      sx={{ mb: 1 }}
                      variant="h6"
                    >
                      Payment #{calculatePayment(id)}
                    </Typography>
                    <Typography
                      color="textSecondary"
                      sx={{ mb: 1 }}
                      variant="body2"
                    >
                      Status: {currentOrder.status_text}
                    </Typography>
                    <Typography
                      color="textSecondary"
                      sx={{ mb: 1 }}
                      variant="body2"
                    >
                      {format(new Date(currentOrder.start), 'dd MMM yyyy')} {format(new Date(currentOrder.start), 'HH:mm')}
                    </Typography>
                    <Card
                      elevation={0}
                      variant="outlined"
                      sx={{
                        alignItems: 'center',
                        borderRadius: 1,
                        p: 2
                      }}
                    >
                      <Typography
                        color="textSecondary"
                        variant="overline"
                      >
                        Your key:
                      </Typography>
                      <Typography
                        color="textPrimary"
                        variant="h6"
                      >
                        {currentOrder.key}
                      </Typography>
                    </Card>
                  </Grid>
                </Grid>
                <Grid>
                  <Card
                    elevation={0}
                    variant="outlined"
                    sx={{
                      alignItems: 'center',
                      borderRadius: 1,
                      p: 2,
                    }}
                  >
                    <Typography
                      color="textSecondary"
                      sx={{ mb: 1 }}
                      variant="h6"
                    >
                      Please send
                    </Typography>
                    <Typography
                      color="textPrimary"
                      sx={{ mb: 1 }}
                      variant="h5"
                    >
                      {currentOrder.amount} BTC
                    </Typography>
                    <Typography
                      color="textSecondary"
                      sx={{ mb: 1 }}
                      variant="h6"
                    >
                      To the address
                    </Typography>
                    <Typography
                      color="textPrimary"
                      sx={{ mb: 1 }}
                      variant="h5"
                    >
                      {currentOrder.address}
                    </Typography>
                     {
                      currentOrder.status === 0 && difference && (
                        <>
                          <Divider />
                          <Typography
                            color="textSecondary"
                            sx={{ mb: 1, mt: 1 }}
                            variant="h6"
                          >
                            Please pay before time expires.
                          </Typography>
                          <Grid
                            item
                            xs={12}
                            sx={{
                              mb : 1,
                              mt: 2,
                              display: 'flex',
                              justifyContent: 'center'
                            }}
                          >
                            <CountdownCircleTimer
                              isPlaying
                              duration={difference}
                              colors={[
                                ['#5658DD', 0.33],
                                ['#FFA173', 0.33],
                                ['#FF6171', 0.33],
                              ]}
                            >
                              {({ remainingTime }) => ( 
                                <div>
                                  <Typography
                                    color="textSecondary"
                                    sx={{ 
                                      mb: 1, 
                                      mt: 1,
                                      display: 'flex',
                                     justifyContent: 'center'
                                    }}
                                    variant="h6"
                                  >
                                    {convertHMS(remainingTime)}
                                  </Typography>
                                  <Typography
                                    color="textSecondary"
                                    sx={{ mb: 1, mt: 1 }}
                                    variant="body1"
                                  >
                                    Remaining time
                                  </Typography>
                                </div>
                              ) }
                            </CountdownCircleTimer>
                          </Grid>
                        </>
                      )
                     }
                  </Card>
                </Grid>
              </Card>
            </Grid>
            <Grid
              item
              md={4}
              xs={12}
              sx={{
                pl: 2
              }}
            >
              {stats.map((item) => (
                <Grid
                  item
                  key={item.label}
                  xs={12}
                  sx={{
                    mb : 1
                  }}
                >
                  <SummaryItem
                    content={item.content}
                    icon={item.icon}
                    label={item.label}
                  />
                </Grid>
              ))}
            </Grid>
          </Grid>
        </Container>
      </Box>
      </LoadingScreen>
    </>
  );
}