@if(!empty($icon) && (str_starts_with($icon, 'storage/') || str_starts_with($icon, 'uploads/') || str_starts_with($icon, 'http') || str_contains($icon, '/')))
  <img src="{{ asset($icon) }}" class="{{ $class ?? 'size-5' }} object-contain" alt="">
@elseif(($icon ?? '') === 'code')
  <svg class="{{ $class ?? 'size-5' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <polyline points="16 18 22 12 16 6"/>
    <polyline points="8 6 2 12 8 18"/>
  </svg>
@elseif(($icon ?? '') === 'cpu' || ($icon ?? '') === 'ai')
  <svg class="{{ $class ?? 'size-5' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <rect width="16" height="16" x="4" y="4" rx="2"/>
    <rect width="6" height="6" x="9" y="9" rx="1"/>
    <path d="M15 2v2M15 20v2M2 15h2M2 9h2M20 15h2M20 9h2M9 2v2M9 20v2"/>
  </svg>
@elseif(($icon ?? '') === 'shield' || ($icon ?? '') === 'security')
  <svg class="{{ $class ?? 'size-5' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"/>
  </svg>
@elseif(($icon ?? '') === 'globe')
  <svg class="{{ $class ?? 'size-5' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <circle cx="12" cy="12" r="10"/>
    <path d="M12 2a14.5 14.5 0 0 0 0 20 14.5 14.5 0 0 0 0-20"/>
    <path d="M2 12h20"/>
  </svg>
@elseif(($icon ?? '') === 'database')
  <svg class="{{ $class ?? 'size-5' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <ellipse cx="12" cy="5" rx="9" ry="3"/>
    <path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"/>
    <path d="M3 12c0 1.66 4 3 9 3s9-1.34 9-3"/>
  </svg>
@elseif(($icon ?? '') === 'palette')
  <svg class="{{ $class ?? 'size-5' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/>
    <circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/>
    <circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/>
    <circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/>
    <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/>
  </svg>
@elseif(($icon ?? '') === 'terminal')
  <svg class="{{ $class ?? 'size-5' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <polyline points="4 17 10 11 4 5"/>
    <line x1="12" y1="19" x2="20" y2="19"/>
  </svg>
@elseif(($icon ?? '') === 'briefcase' || ($icon ?? '') === 'business')
  <svg class="{{ $class ?? 'size-5' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <rect width="20" height="14" x="2" y="7" rx="2" ry="2"/>
    <path d="M16 21V5a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/>
  </svg>
@elseif(($icon ?? '') === 'book')
  <svg class="{{ $class ?? 'size-5' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H20v20H6.5a2.5 2.5 0 0 1-2.5-2.5Z"/>
    <path d="M6 6h10"/>
    <path d="M6 10h7"/>
  </svg>
@elseif(($icon ?? '') === 'smartphone')
  <svg class="{{ $class ?? 'size-5' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <rect width="14" height="20" x="5" y="2" rx="2" ry="2"/>
    <path d="M12 18h.01"/>
  </svg>
@elseif(($icon ?? '') === 'server')
  <svg class="{{ $class ?? 'size-5' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <rect width="20" height="8" x="2" y="2" rx="2" ry="2"/>
    <rect width="20" height="8" x="2" y="14" rx="2" ry="2"/>
    <line x1="6" y1="6" x2="6.01" y2="6"/>
    <line x1="6" y1="18" x2="6.01" y2="18"/>
  </svg>
@elseif(($icon ?? '') === 'layers')
  <svg class="{{ $class ?? 'size-5' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <polygon points="12 2 2 7 12 12 22 7 12 2"/>
    <polyline points="2 17 12 22 22 17"/>
    <polyline points="2 12 12 17 22 12"/>
  </svg>
@else
  <svg class="{{ $class ?? 'size-5' }}" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
    <path d="m12 3-1.912 5.813a2 2 0 0 1-1.275 1.275L3 12l5.813 1.912a2 2 0 0 1 1.275 1.275L12 21l1.912-5.813a2 2 0 0 1 1.275-1.275L21 12l-5.813-1.912a2 2 0 0 1-1.275-1.275L12 3Z"/>
    <path d="M5 3v4"/>
    <path d="M19 17v4"/>
    <path d="M3 5h4"/>
    <path d="M17 19h4"/>
  </svg>
@endif
