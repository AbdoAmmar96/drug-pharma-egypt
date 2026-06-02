export default function ContactIllustration() {
  return (
    <svg
      viewBox="0 0 280 280"
      xmlns="http://www.w3.org/2000/svg"
      className="hero-illustration"
      aria-label="Customer service representative illustration"
    >
      <defs>
        <radialGradient id="bg-glow-contact" cx="50%" cy="40%" r="60%">
          <stop offset="0%" stopColor="#FBE3D2" stopOpacity="0.6" />
          <stop offset="100%" stopColor="#FBE3D2" stopOpacity="0" />
        </radialGradient>
        <linearGradient id="shirt-grad" x1="0%" y1="0%" x2="0%" y2="100%">
          <stop offset="0%" stopColor="#2A337A" />
          <stop offset="100%" stopColor="#1B2360" />
        </linearGradient>
        <linearGradient id="skin-grad" x1="0%" y1="0%" x2="0%" y2="100%">
          <stop offset="0%" stopColor="#F4C49A" />
          <stop offset="100%" stopColor="#E8B083" />
        </linearGradient>
      </defs>

      <circle cx="140" cy="140" r="135" fill="url(#bg-glow-contact)" />

      {/* Ground shadow */}
      <ellipse cx="140" cy="262" rx="80" ry="6" fill="#1B2360" opacity="0.1" />

      {/* === Body / shirt === */}
      <path
        d="M70,260 Q70,200 100,180 L100,170 L180,170 L180,180 Q210,200 210,260 Z"
        fill="url(#shirt-grad)"
      />
      {/* Collar */}
      <path
        d="M115,170 L140,200 L165,170 L155,165 L140,180 L125,165 Z"
        fill="#fff"
      />
      {/* Tie / accent */}
      <path
        d="M137,200 L143,200 L145,225 L140,235 L135,225 Z"
        fill="#E87330"
      />

      {/* Name badge */}
      <g transform="translate(165, 215)">
        <rect width="22" height="14" rx="2" fill="#fff" />
        <line x1="3" y1="5" x2="19" y2="5" stroke="#1B2360" strokeWidth="1" />
        <line x1="3" y1="9" x2="14" y2="9" stroke="#1B2360" strokeWidth="1" opacity="0.5" />
      </g>

      {/* === Neck === */}
      <rect x="125" y="140" width="30" height="35" fill="url(#skin-grad)" />
      {/* Neck shadow */}
      <path d="M125,160 L155,160 L155,175 L125,175 Z" fill="#1B2360" opacity="0.1" />

      {/* === Head === */}
      <ellipse cx="140" cy="115" rx="45" ry="50" fill="url(#skin-grad)" />

      {/* Hair (short, dark) */}
      <path
        d="M95,105 Q92,72 122,62 Q150,55 175,72 Q188,90 185,108 Q180,95 165,90 Q150,86 138,90 Q115,92 105,108 Z"
        fill="#1B2360"
      />
      {/* Hair side accent (orange highlight) */}
      <path
        d="M178,95 Q186,98 185,108 Q180,98 172,94 Z"
        fill="#E87330"
        opacity="0.6"
      />

      {/* Ear */}
      <ellipse cx="96" cy="120" rx="6" ry="9" fill="url(#skin-grad)" />

      {/* === Headset === */}
      {/* Band over head */}
      <path
        d="M95,110 Q95,75 140,70 Q185,75 185,110"
        stroke="#1B2360"
        strokeWidth="6"
        fill="none"
        strokeLinecap="round"
      />
      {/* Right ear cup */}
      <g transform="translate(185, 110)">
        <circle r="11" fill="#1B2360" />
        <circle r="6" fill="#E87330" />
      </g>
      {/* Left ear cup */}
      <g transform="translate(95, 110)">
        <circle r="11" fill="#1B2360" />
        <circle r="6" fill="#E87330" />
      </g>
      {/* Microphone arm */}
      <path
        d="M95,118 Q90,135 105,148"
        stroke="#1B2360"
        strokeWidth="3.5"
        fill="none"
        strokeLinecap="round"
      />
      {/* Mic head */}
      <ellipse cx="108" cy="150" rx="6" ry="4" fill="#1B2360" transform="rotate(20 108 150)" />
      <ellipse cx="108" cy="150" rx="3" ry="2" fill="#E87330" transform="rotate(20 108 150)" />

      {/* === Face === */}
      {/* Eyebrows */}
      <path d="M118,103 Q126,99 132,103" stroke="#1B2360" strokeWidth="2.5" fill="none" strokeLinecap="round" />
      <path d="M148,103 Q156,99 162,103" stroke="#1B2360" strokeWidth="2.5" fill="none" strokeLinecap="round" />

      {/* Eyes */}
      <g fill="#1B2360">
        <ellipse cx="124" cy="113" rx="3" ry="3.5" />
        <ellipse cx="156" cy="113" rx="3" ry="3.5" />
      </g>
      {/* Eye highlights */}
      <g fill="#fff">
        <circle cx="125" cy="112" r="1" />
        <circle cx="157" cy="112" r="1" />
      </g>

      {/* Cheeks */}
      <ellipse cx="115" cy="128" rx="6" ry="4" fill="#E87330" opacity="0.35" />
      <ellipse cx="165" cy="128" rx="6" ry="4" fill="#E87330" opacity="0.35" />

      {/* Nose */}
      <path d="M138,118 Q138,128 140,132 Q144,134 146,131" stroke="#1B2360" strokeWidth="1.5" fill="none" strokeLinecap="round" opacity="0.6" />

      {/* Smile */}
      <path
        d="M126,140 Q140,152 154,140"
        stroke="#1B2360"
        strokeWidth="3"
        fill="none"
        strokeLinecap="round"
      />
      {/* Teeth hint */}
      <path
        d="M130,141 Q140,148 150,141"
        fill="#fff"
      />

      {/* === Speech bubble === */}
      <g transform="translate(190, 70)">
        <path
          d="M5,5 Q5,0 10,0 L60,0 Q65,0 65,5 L65,30 Q65,35 60,35 L25,35 L15,46 L18,35 L10,35 Q5,35 5,30 Z"
          fill="#fff"
          stroke="#1B2360"
          strokeWidth="2"
        />
        {/* Three dots (typing) */}
        <circle cx="22" cy="18" r="3" fill="#E87330" />
        <circle cx="35" cy="18" r="3" fill="#E87330" opacity="0.7" />
        <circle cx="48" cy="18" r="3" fill="#E87330" opacity="0.4" />
      </g>

      {/* Sparkles */}
      <g fill="#E87330" opacity="0.7">
        <path d="M60,80 L62,85 L67,86 L62,87 L60,92 L58,87 L53,86 L58,85 Z" />
        <circle cx="40" cy="160" r="2.5" />
        <circle cx="240" cy="200" r="2" />
      </g>
      <g fill="#1B2360" opacity="0.4">
        <circle cx="50" cy="50" r="1.8" />
        <circle cx="250" cy="50" r="2" />
      </g>
    </svg>
  )
}
