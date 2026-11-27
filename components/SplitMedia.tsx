import type { ReactNode } from "react";
import type { MediaAsset } from "@/lib/media";
import { MediaFrame } from "./MediaFrame";

export function SplitMedia({
  item,
  children,
  tone = "night",
  hero = false,
}: {
  item: MediaAsset;
  children: ReactNode;
  tone?: "night" | "khaki";
  hero?: boolean;
}) {
  return (
    <section
      className={`split-media ${tone === "khaki" ? "split-media-khaki" : ""} ${hero ? "split-media-hero" : ""}`}
    >
      <div className="split-media-visual">
        <MediaFrame item={item} />
      </div>
      <div className="split-media-copy">{children}</div>
    </section>
  );
}
