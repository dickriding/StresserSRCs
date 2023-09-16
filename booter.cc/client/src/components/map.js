import React from 'react'
import { MapContainer, Marker, Popup, TileLayer } from 'react-leaflet'

class MyMap extends React.Component {
  constructor () {
    super()
    this.state = {
      zoom: 13
    }
  }

  render () {
    const position = [this.props.lat, this.props.lng]
    return (
        <MapContainer style={{
          width: '100%',
          height: '100%'
        }}
          center={position} 
          zoom={this.state.zoom}
        >
          <TileLayer
            url='https://tiles.stadiamaps.com/tiles/alidade_smooth_dark/{z}/{x}/{y}.png'
          />
          <Marker position={position}>
            <Popup>
              <span>Your target.</span>
            </Popup>
          </Marker>
        </MapContainer>
      )
  }
}

export default MyMap
