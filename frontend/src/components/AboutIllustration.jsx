export default function AboutIllustration() {
  return (
    <svg
      viewBox="0 0 280 280"
      xmlns="http://www.w3.org/2000/svg"
      className="hero-illustration"
      aria-label="Pharmaceutical laboratory illustration"
    >
      {/* Soft background blob */}
      <defs>
        <radialGradient id="bg-glow-about" cx="50%" cy="40%" r="60%">
          <stop offset="0%" stopColor="#FBE3D2" stopOpacity="0.6" />
          <stop offset="100%" stopColor="#FBE3D2" stopOpacity="0" />
        </radialGradient>
        <linearGradient id="liquid-orange" x1="0%" y1="0%" x2="0%" y2="100%">
          <stop offset="0%" stopColor="#E87330" />
          <stop offset="100%" stopColor="#C95A1B" />
        </linearGradient>
        <linearGradient id="liquid-navy" x1="0%" y1="0%" x2="0%" y2="100%">
          <stop offset="0%" stopColor="#2A337A" />
          <stop offset="100%" stopColor="#1B2360" />
        </linearGradient>
      </defs>

      <circle cx="140" cy="140" r="135" fill="url(#bg-glow-about)" />

      {/* Factory building (background) */}
      <g opacity="0.18">
        <rect x="40" y="70" width="200" height="100" rx="4" fill="#1B2360" />
        {/* Roof teeth */}
        <path d="M40,70 L60,55 L80,70 L100,55 L120,70 L140,55 L160,70 L180,55 L200,70 L220,55 L240,70 Z" fill="#1B2360" />
        {/* Windows */}
        <rect x="60"  y="90" width="14" height="18" fill="#FBE3D2" />
        <rect x="84"  y="90" width="14" height="18" fill="#FBE3D2" />
        <rect x="108" y="90" width="14" height="18" fill="#FBE3D2" />
        <rect x="132" y="90" width="14" height="18" fill="#FBE3D2" />
        <rect x="156" y="90" width="14" height="18" fill="#FBE3D2" />
        <rect x="180" y="90" width="14" height="18" fill="#FBE3D2" />
        <rect x="204" y="90" width="14" height="18" fill="#FBE3D2" />
        {/* Chimney */}
        <rect x="195" y="40" width="14" height="40" fill="#1B2360" />
      </g>

      {/* Ground / base shadow */}
      <ellipse cx="140" cy="240" rx="110" ry="8" fill="#1B2360" opacity="0.08" />

      {/* Erlenmeyer flask (left) */}
      <g transform="translate(50, 130)">
        {/* Liquid */}
        <path d="M22,30 L22,40 L4,80 Q4,90 14,90 L60,90 Q70,90 70,80 L52,40 L52,30 Z" fill="url(#liquid-orange)" />
        {/* Glass body */}
        <path
          d="M28,10 L28,40 L8,80 Q8,90 18,90 L56,90 Q66,90 66,80 L46,40 L46,10 Z"
          fill="none"
          stroke="#1B2360"
          strokeWidth="2.5"
          strokeLinejoin="round"
        />
        {/* Top opening */}
        <rect x="26" y="6" width="22" height="6" rx="1.5" fill="#1B2360" />
        {/* Bubbles */}
        <circle cx="30" cy="60" r="3" fill="#fff" opacity="0.7" />
        <circle cx="42" cy="48" r="2" fill="#fff" opacity="0.7" />
        <circle cx="24" cy="72" r="2.5" fill="#fff" opacity="0.7" />
        {/* Highlight */}
        <path d="M14,70 Q14,82 22,86" stroke="#fff" strokeWidth="2" fill="none" opacity="0.6" strokeLinecap="round" />
      </g>

      {/* Test tube (center, tall) */}
      <g transform="translate(132, 110)">
        {/* Liquid */}
        <path d="M2,60 L2,108 Q2,122 14,122 Q26,122 26,108 L26,60 Z" fill="url(#liquid-navy)" />
        {/* Glass */}
        <path
          d="M2,8 L2,108 Q2,122 14,122 Q26,122 26,108 L26,8 Z"
          fill="none"
          stroke="#1B2360"
          strokeWidth="2.5"
          strokeLinejoin="round"
        />
        {/* Top */}
        <rect x="0" y="2" width="28" height="8" rx="2" fill="#1B2360" />
        {/* Measurement marks */}
        <line x1="2"  y1="40" x2="8"  y2="40" stroke="#1B2360" strokeWidth="1.5" />
        <line x1="2"  y1="55" x2="6"  y2="55" stroke="#1B2360" strokeWidth="1.5" />
        <line x1="2"  y1="70" x2="8"  y2="70" stroke="#1B2360" strokeWidth="1.5" />
        <line x1="2"  y1="85" x2="6"  y2="85" stroke="#1B2360" strokeWidth="1.5" />
        {/* Bubbles */}
        <circle cx="14" cy="92" r="2" fill="#fff" opacity="0.7" />
        <circle cx="20" cy="78" r="1.5" fill="#fff" opacity="0.7" />
      </g>

      {/* Pill bottle (right) */}
      <g transform="translate(180, 145)">
        {/* Body */}
        <rect x="0" y="14" width="56" height="76" rx="6" fill="#fff" stroke="#1B2360" strokeWidth="2.5" />
        {/* Cap */}
        <rect x="6" y="0" width="44" height="20" rx="3" fill="#E87330" />
        {/* Label */}
        <rect x="6" y="36" width="44" height="36" rx="2" fill="#1B2360" opacity="0.08" />
        {/* Cross icon (medical) */}
        <g transform="translate(28, 54)">
          <rect x="-9" y="-2" width="18" height="4" rx="1" fill="#E87330" />
          <rect x="-2" y="-9" width="4" height="18" rx="1" fill="#E87330" />
        </g>
      </g>

      {/* Loose pills (foreground) */}
      <g transform="translate(95, 220)">
        {/* Pill 1 (capsule, navy + orange) */}
        <g transform="rotate(-20)">
          <rect x="0" y="0" width="32" height="14" rx="7" fill="#E87330" />
          <rect x="0" y="0" width="16" height="14" rx="7" fill="#1B2360" />
        </g>
      </g>
      <g transform="translate(140, 215)">
        {/* Pill 2 (round, two-tone) */}
        <g transform="rotate(15)">
          <circle cx="10" cy="10" r="10" fill="#FBE3D2" stroke="#1B2360" strokeWidth="1.5" />
          <path d="M2,10 L18,10" stroke="#1B2360" strokeWidth="1.5" />
        </g>
      </g>
      <g transform="translate(170, 222)">
        {/* Pill 3 */}
        <g transform="rotate(-8)">
          <rect x="0" y="0" width="26" height="12" rx="6" fill="#1B2360" />
          <rect x="0" y="0" width="13" height="12" rx="6" fill="#E87330" />
        </g>
      </g>

      {/* Plant leaf (top right, organic touch) */}
      <g transform="translate(215, 60) rotate(20)" opacity="0.85">
        <path
          d="M0,0 Q-4,-22 14,-30 Q26,-22 16,-2 Q8,4 0,0 Z"
          fill="#1B2360"
          opacity="0.6"
        />
        <path
          d="M2,-2 Q4,-18 14,-24"
          stroke="#FBE3D2"
          strokeWidth="1"
          fill="none"
        />
      </g>
      <g transform="translate(220, 70) rotate(50)" opacity="0.85">
        <path
          d="M0,0 Q-3,-16 12,-22 Q22,-16 14,-2 Q6,2 0,0 Z"
          fill="#E87330"
          opacity="0.7"
        />
      </g>

      {/* Sparkles */}
      <g fill="#E87330" opacity="0.7">
        <circle cx="60"  cy="50"  r="2.5" />
        <circle cx="245" cy="180" r="2" />
        <circle cx="40"  cy="200" r="2" />
        <circle cx="220" cy="20"  r="2" />
      </g>
      <g fill="#1B2360" opacity="0.5">
        <circle cx="80"  cy="30"  r="1.8" />
        <circle cx="250" cy="100" r="1.8" />
      </g>
    </svg>
  )
}
