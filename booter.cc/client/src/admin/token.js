import { useEffect, useState } from 'react';
import { Helmet } from 'react-helmet';
import {
  useParams
} from "react-router-dom";
import { Box, Card, Container, Grid, Typography } from '@material-ui/core';
import { format, getTime } from 'date-fns';
import Axios from '../handler/axios';
import { SummaryItem } from '../components/reports/summary-item';
import { Boots as BootsIcon } from '../icons/boots';
import { Time as TimeIcon } from '../icons/time';
import { Calender as CalenderIcon } from '../icons/calender';
import { Concurrent as ConcurrentIcon } from '../icons/concurrent';
import { APIYES as APIYESICON } from '../icons/api-yes';
import { APINO as APINOICON } from '../icons/api-no';
import { Loop as LoopIcon } from '../icons/loop';
import LoadingScreen from 'react-loading-screen';
import authenticate2 from '../handler/authenticate2';

export const TokenACP = () => {
  const [loading, setLoading] = useState(true)
  const [currentToken, setToken] = useState({
    value: null,
    usedBy: null,
    usedAt: null,
    createdAt: null,
    createdBy: null
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
    },
    {
      content: 'No',
      icon: LoopIcon,
      label: 'Loop'
    },
  ]);
  const { id } = useParams();
  const checkToken = async () => {
    const authRequest = await authenticate2()
    if(!authRequest) {
      window.location.href = '/404'
    } else {
      const token = getTime(new Date())
      const request = await Axios.get(`/admin/getToken/${token}/${id}`)
      if(request.data.success) {
        setToken(request.data.message)
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
            content: request.data.message.maxBoots,
            icon: BootsIcon,
            label: 'Boots'
          },
          {
            content: request.data.message.api_access ? 'Yes' : 'No',
            icon: request.data.message.api_access ? APIYESICON : APINOICON,
            label: 'API'
          },
          {
            content: request.data.message.loop ? 'Yes' : 'No',
            icon: LoopIcon,
            label: 'Loop'
          }
        ])
        setLoading(false)
      } else {
        window.location.href = '/404'
      }
    } 
  }
  useEffect( () => {
    checkToken()
  }, [])
  return(
    <>
      <Helmet>
        <title>ACP - Token {id} | BOOTER.CC</title>
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
            Token overview
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
                    sm={12}
                  > 
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
                        Token key:
                      </Typography>
                      <Typography
                        color="textPrimary"
                        variant="h6"
                      >
                        {currentToken.value}
                      </Typography>
                    </Card>
                  </Grid>
                  <Grid 
                    item 
                    sm={12}
                  >
                    <Box
                      sx={{
                        mt: 2
                      }}
                    >
                        <Typography
                          color="textSecondary"
                          variant="body2"
                          sx={{ mb: 1 }}
                        >
                          {
                            currentToken.used ? 
                            `Claimed by: ${currentToken.usedBy}`
                            : 'This token is unused.'
                          }
                        </Typography>
                        {
                          currentToken.used && (
                            <Typography
                              color="textSecondary"
                              sx={{ mb: 1 }}
                              variant="body2"
                            >
                              Claim at: 
                              {format(new Date(currentToken.usedAt), 'dd MMM yyyy')} {format(new Date(currentToken.usedAt), 'HH:mm')}
                            </Typography>
                          )
                        }
                        <Typography
                          color="textSecondary"
                          sx={{ mb: 1 }}
                          variant="body2"
                        >
                          Created by:  
                          {currentToken.createdBy}
                        </Typography>
                        <Typography
                          color="textSecondary"
                          sx={{ mb: 1 }}
                          variant="body2"
                        >
                          Created at:  
                          {format(new Date(currentToken.createdAt), 'dd MMM yyyy')} {format(new Date(currentToken.createdAt), 'HH:mm')}
                        </Typography>
                    </Box>
                  </Grid>
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