const errorHandlingAxios = (err) => {
  let statusCode = 500
  let message = 'Kesalahan teknis. Hubungi developer aplikasi.'
  if (typeof(err) === 'object') {
    if ('response' in err && 'status' in err.response) {
      statusCode = err.response.status
      if (err.response.status === 401) {
        message = 'unauthenticated'
      } else if (err.response.status === 404) {
        message = 'not found'
      } else if (err.response.status === 0) {
        message = 'Tidak ada data'
      }
    }
  }
  return {
    statusCode,
    message
  }
}

export default errorHandlingAxios