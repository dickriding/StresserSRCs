import { 
  Box, 
  Card, 
  CardContent, 
  CardHeader, 
  Divider, 
  Typography 
} from '@material-ui/core';


export const TowerIndicators = (props) => {
  const currData = props.data;

  const stats = [
    {
      content: `${currData.revenue}$`,
      label: 'Revenue'
    },
    {
      content: `${currData.net}$`,
      label: 'NET'
    },
    {
      content: `${currData.pendingorders}$`,
      label: 'Pending orders'
    },
    {
      content:`${currData.overdue}$`,
      label: 'Overdue'
    }
  ];

  return (
    <Box
      sx={{
        gap: 3,
        display: 'grid',
        gridTemplateColumns: {
          md: 'repeat(4, 1fr)',
          sm: 'repeat(2, 1fr)',
          xs: 'repeat(1, 1fr)'
        }
      }}
    >
      {stats.map((item) => (
        <Card
          elevation={0}
          variant="outlined"
          key={item.label}
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
            {item.label}
          </Typography>
          <Typography
            color="textPrimary"
            variant="h6"
          >
            {item.content}
          </Typography>
        </Card>
      ))}
    </Box>
  );
};