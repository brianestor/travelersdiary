"use client";

import { useEffect, useRef } from "react";

export function VideoFrame({ src, label, className }: { src: string; label: string; className: string }) {
  const video = useRef<HTMLVideoElement>(null);

  useEffect(() => {
    const node = video.current;
    if (!node) return;
    const reduce = window.matchMedia("(prefers-reduced-motion: reduce)").matches;
    if (reduce) {
      node.pause();
      node.currentTime = 0;
      return;
    }
    void node.play().catch(() => undefined);
  }, []);

  return (
    <video
      ref={video}
      className={className}
      src={src}
      muted
      loop
      playsInline
      preload="auto"
      aria-label={label}
    />
  );
}
