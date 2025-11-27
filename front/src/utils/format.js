import { DateTime, Settings } from 'luxon'

Settings.defaultLocale = 'ru'

export function formatLocalDateTime(time) {
  if (!time) return ''
  const formatedTime = time.replace(' ', 'T');
  return DateTime.fromISO(formatedTime).toFormat('dd LLL yyyy в T')
}
