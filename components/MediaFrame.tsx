import type { MediaAsset } from "@/lib/media";
import { VideoFrame } from "./VideoFrame";

const frameClass: Record<MediaAsset["ratio"], string> = {
  portrait: "frame-portrait",
  square: "frame-square",
  landscape: "frame-landscape",
  "video-portrait": "frame-video-portrait",
  "video-landscape": "frame-video-landscape",
};

export function MediaFrame({ item }: { item: MediaAsset }) {
  const fit = item.ratio === "landscape" || item.ratio === "video-landscape" ? "object-contain" : "object-cover object-center";
  const box = `mx-auto overflow-hidden bg-night ${frameClass[item.ratio]}`;

  if (item.kind === "video") {
    return (
      <div className={box}>
        <VideoFrame src={item.src} label={item.alt} className={`h-full w-full ${fit}`} />
      </div>
    );
  }

  return (
    <div className={box}>
      {/* eslint-disable-next-line @next/next/no-img-element */}
      <img src={item.src} alt={item.alt} className={`h-full w-full ${fit}`} />
    </div>
  );
}
